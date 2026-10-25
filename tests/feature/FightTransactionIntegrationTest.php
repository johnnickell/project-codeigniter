<?php

declare(strict_types=1);

namespace Tests\Feature;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Test\CIUnitTestCase;
use DomainException;
use Fight\Common\Adapter\Persistence\CodeIgniter\CodeIgniterTransactionalUnitOfWork;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use RuntimeException;
use stdClass;

/**
 * Tests the selected adapter's failure contract; doubles do not prove database outcomes
 */
final class FightTransactionIntegrationTest extends CIUnitTestCase
{
    /**
     * @param 'transBegin'|'transStatus'|'transCommit' $method
     */
    #[DataProvider('transactionFailures')]
    public function test_transaction_method_failures_do_not_run_or_publish_unconfirmed_work(
        string $method,
        bool $throws,
        bool $callbackRuns,
        bool $cleanup
    ): void {
        $connection = $this->connection();
        $failure = new RuntimeException('transaction acknowledgement failed');
        foreach (['transBegin', 'transStatus', 'transCommit'] as $operation) {
            $expectation = $connection->method($operation);
            if ($operation === $method && $throws) {
                $expectation->willThrowException($failure);
            } else {
                $expectation->willReturn($operation !== $method);
            }
        }
        $connection->expects($cleanup ? self::once() : self::never())->method('transRollback')->willReturn(true);
        $connection->expects($cleanup ? self::once() : self::never())->method('resetTransStatus')->willReturnSelf();
        $ran = false;
        $published = false;
        try {
            (new CodeIgniterTransactionalUnitOfWork($connection))->commitTransactional(
                static function () use (&$ran): string {
                    $ran = true;

                    return 'unconfirmed';
                }
            );
            $published = true;
            self::fail('Unconfirmed work must not return as committed.');
        } catch (RuntimeException $caught) {
            if ($throws) {
                self::assertSame($failure, $caught);
            } else {
                self::assertSame(match ($method) {
                    'transBegin' => 'Could not begin CodeIgniter transaction.',
                    'transStatus' => 'CodeIgniter transaction failed.',
                    'transCommit' => 'Could not commit CodeIgniter transaction.',
                }, $caught->getMessage());
            }
        }
        self::assertSame($callbackRuns, $ran);
        self::assertFalse($published);
    }

    /**
     * @return iterable<string, array{'transBegin'|'transStatus'|'transCommit', bool, bool, bool}>
     */
    public static function transactionFailures(): iterable
    {
        yield 'begin false' => ['transBegin', false, false, false];
        yield 'begin throws' => ['transBegin', true, false, false];
        yield 'status false' => ['transStatus', false, true, true];
        yield 'status throws' => ['transStatus', true, true, false];
        yield 'commit false' => ['transCommit', false, true, true];
        yield 'commit throws: no cleanup guarantee' => ['transCommit', true, true, false];
    }

    #[DataProvider('cleanupFailures')]
    public function test_cleanup_cannot_replace_the_original_callback_failure(string $cleanupFailure): void
    {
        $connection = $this->connection();
        $connection->method('transBegin')->willReturn(true);
        $connection->expects(self::never())->method('transCommit');
        $rollback = $connection->expects(self::once())->method('transRollback');
        if ($cleanupFailure === 'rollback throws') {
            $rollback->willThrowException(new RuntimeException('rollback failed'));
        } else {
            $rollback->willReturn(false);
        }
        $reset = $connection->expects(self::once())->method('resetTransStatus');
        if ($cleanupFailure === 'reset throws') {
            $reset->willThrowException(new RuntimeException('reset failed'));
        } else {
            $reset->willReturnSelf();
        }
        $original = new DomainException('original callback failure');
        try {
            (new CodeIgniterTransactionalUnitOfWork($connection))->commitTransactional(static fn () => throw $original);
            self::fail('Callback failure must propagate.');
        } catch (DomainException $caught) {
            self::assertSame($original, $caught);
        }
    }

    /**
     * @return iterable<array{string}>
     */
    public static function cleanupFailures(): iterable
    {
        yield ['rollback false'];
        yield ['rollback throws'];
        yield ['reset throws'];
    }

    public function test_established_then_closed_connection_rejects_callback(): void
    {
        $connection = $this->connection();
        $connection->method('getConnection')->willReturnOnConsecutiveCalls(new stdClass(), false);
        $connection->expects(self::never())->method('transBegin');
        $transaction = new CodeIgniterTransactionalUnitOfWork($connection);
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('closed connection');
        $transaction->commitTransactional(static fn () => self::fail('Closed connection ran callback.'));
    }

    public function test_factory_uses_selected_connection_and_publishes_only_after_real_commit(): void
    {
        $db = db_connect();
        $db->query('CREATE TABLE db_transaction_ordering (value TEXT NOT NULL)');
        try {
            $transaction = service('fightTransactionalUnitOfWork');
            $result = $transaction->commitTransactional(static function () use ($db, $transaction): string {
                self::assertSame(1, $db->transDepth, 'Factory must use this actual selected connection.');
                $db->table('transaction_ordering')->insert(['value' => 'committed']);
                try {
                    $transaction->commitTransactional(static fn () => self::fail('Nested callback ran.'));
                    self::fail('Nested execution was accepted.');
                } catch (LogicException $caught) {
                    self::assertSame('Nested transactional execution is not supported.', $caught->getMessage());
                }

                return 'confirmed';
            });
            self::assertSame('confirmed', $result);
            self::assertSame(0, $db->transDepth);
            $observed = [];
            $dispatcher = service('fightSynchronousEventDispatcher');
            $dispatcher->register(new class ($db, $observed) implements
                \Fight\Common\Application\Messaging\Event\EventSubscriber
            {
                /**
                 * @param BaseConnection $db
                 * @param array $observed
                 *
                 * @phpstan-param BaseConnection<mixed, mixed> $db
                 * @phpstan-param list<mixed> $observed
                 */
                public function __construct(
                    private BaseConnection $db,
                    // Assertions read the referenced collection outside this double.
                    private array &$observed // @phpstan-ignore property.onlyWritten
                ) {
                }
                public static function eventRegistration(): array
                {
                    return [TransactionCommittedEvent::class => 'publish'];
                }
                public function publish(\Fight\Common\Domain\Messaging\Event\EventMessage $message): void
                {
                    $query = $this->db->table('transaction_ordering')->get();
                    FightTransactionIntegrationTest::assertNotFalse($query);
                    $row = $query->getRow();
                    FightTransactionIntegrationTest::assertIsObject($row);
                    $this->observed = [$this->db->transDepth, $row->value];
                    throw new RuntimeException('subscriber failed after commit');
                }
            });
            try {
                // Consumer publication happens after the transaction returns, not in its callback.
                $dispatcher->trigger(new TransactionCommittedEvent());
                self::fail('Subscriber failure was swallowed.');
            } catch (\Fight\Common\Application\Messaging\Event\EventDispatchFailed $caught) {
                self::assertCount(1, $caught->failures());
            }
            self::assertSame([0, 'committed'], $observed);
            self::assertSame(1, $db->table('transaction_ordering')->countAllResults());

            $original = new DomainException('rollback this mutation');
            try {
                $transaction->commitTransactional(static function () use ($db, $original): void {
                    $db->table('transaction_ordering')->insert(['value' => 'rolled back']);
                    throw $original;
                });
                self::fail('Callback failure was swallowed.');
            } catch (DomainException $caught) {
                self::assertSame($original, $caught);
            }
            self::assertSame(1, $db->table('transaction_ordering')->countAllResults());
            self::assertSame(0, $db->transDepth);

            $db->transBegin();
            try {
                $this->expectException(LogicException::class);
                $this->expectExceptionMessage('Nested transactional execution');
                $transaction->commitTransactional(static fn () => self::fail('Native nesting ran callback.'));
            } finally {
                $db->transRollback();
            }
        } finally {
            $db->query('DROP TABLE db_transaction_ordering');
        }
    }

    /**
     * @return BaseConnection<mixed, mixed>&\PHPUnit\Framework\MockObject\MockObject
     */
    private function connection(): BaseConnection
    {
        return $this->getMockBuilder(BaseConnection::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'getConnection', 'transBegin', 'transStatus', 'transCommit', 'transRollback', 'resetTransStatus'
            ])
            ->getMockForAbstractClass();
    }
}

/**
 * Class TransactionCommittedEvent
 */
final class TransactionCommittedEvent implements \Fight\Common\Domain\Messaging\Event\Event
{
    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): static
    {
        return new self();
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
