<?php

declare(strict_types=1);

use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Queue\Events\QueueEvent;
use CodeIgniter\Queue\Events\QueueEventManager;
use CodeIgniter\Test\CIUnitTestCase;
use Fight\Common\Adapter\Http\CodeIgniter\JSendResponse;
use Fight\Common\Domain\Messaging\Command\Command;
use Fight\Common\Domain\Messaging\Command\CommandMessage;
use Fight\Common\Domain\Messaging\Event\Event;
use Fight\Common\Domain\Messaging\Event\EventMessage;

/** @internal */
final class FrameworkSupportJourneyTest extends CIUnitTestCase
{
    private string $filesystemPath;

    protected function setUp(): void
    {
        parent::setUp();

        $db = db_connect();
        $db->query('CREATE TABLE IF NOT EXISTS db_queue_jobs (id INTEGER PRIMARY KEY AUTOINCREMENT, queue TEXT NOT NULL, payload TEXT NOT NULL, priority TEXT NOT NULL DEFAULT "default", status INTEGER NOT NULL DEFAULT 0, attempts INTEGER NOT NULL DEFAULT 0, available_at INTEGER NOT NULL, created_at INTEGER NOT NULL)');
        $db->query('CREATE TABLE IF NOT EXISTS db_queue_jobs_failed (id INTEGER PRIMARY KEY AUTOINCREMENT, connection TEXT NOT NULL, queue TEXT NOT NULL, payload TEXT NOT NULL, priority TEXT NOT NULL DEFAULT "default", exception TEXT NOT NULL, failed_at INTEGER NOT NULL)');
        $db->query('CREATE TABLE IF NOT EXISTS db_receipt_transactions (value TEXT NOT NULL)');

        $this->filesystemPath = WRITEPATH . 'framework-support-journey-' . bin2hex(random_bytes(4));
    }

    protected function tearDown(): void
    {
        service('fightFilesystem')->remove($this->filesystemPath);
        db_connect()->query('DROP TABLE IF EXISTS db_queue_jobs');
        db_connect()->query('DROP TABLE IF EXISTS db_queue_jobs_failed');
        db_connect()->query('DROP TABLE IF EXISTS db_receipt_transactions');

        parent::tearDown();
    }

    public function test_selected_codeigniter_and_fallback_delegates_boot(): void
    {
        $loads = 0;
        $cache = service('fightCache');
        $this->assertSame('cached', $cache->read('framework-support-receipt', static function () use (&$loads): string {
            $loads++;

            return 'cached';
        }, 60));
        $this->assertSame('cached', $cache->read('framework-support-receipt', static function () use (&$loads): string {
            $loads++;

            return 'not-used';
        }, 60));
        $this->assertSame(1, $loads);

        $this->assertSame('Fight CodeIgniter receipt', service('fightTemplateEngine')->render('receipt.twig', ['framework' => 'CodeIgniter']));
        $this->assertNotEmpty(service('fightMailFactory')->generateEmbedId());
        $this->assertInstanceOf(\Symfony\Component\Mailer\MailerInterface::class, service('fightMailer'));
        $this->assertInstanceOf(\Fight\Common\Application\Mail\Transport\MailTransport::class, service('fightMailTransport'));

        service('fightFilesystem')->mkdir($this->filesystemPath);
        service('fightFilesystem')->put($this->filesystemPath . '/receipt.txt', 'passed');
        $this->assertSame('passed', service('fightFilesystem')->get($this->filesystemPath . '/receipt.txt'));
    }

    public function test_native_transaction_jsend_and_named_route_seams(): void
    {
        $transaction = service('fightTransactionalUnitOfWork');
        $this->assertSame('committed', $transaction->commitTransactional(static function (): string {
            db_connect()->table('receipt_transactions')->insert(['value' => 'committed']);

            return 'committed';
        }));

        try {
            $transaction->commitTransactional(static function (): void {
                db_connect()->table('receipt_transactions')->insert(['value' => 'rolled-back']);
                throw new \RuntimeException('rollback');
            });
            self::fail('The transaction should rethrow callback failures.');
        } catch (\RuntimeException $exception) {
            $this->assertSame('rollback', $exception->getMessage());
        }

        $this->assertSame(1, db_connect()->table('receipt_transactions')->countAllResults());
        $this->assertSame('/framework-support/receipt', service('fightUrlGenerator')->generate('framework-support-receipt'));

        $response = JSendResponse::success(service('response'));
        $this->assertSame(ResponseInterface::HTTP_OK, $response->getStatusCode());
        $this->assertSame('success', json_decode((string) json_decode($response->getBody(), true), true)['status']);
    }

    public function test_complete_platform_profile_defaults_boot_without_application_services(): void
    {
        $services = [
            'fightPasswordHasher', 'fightPasswordValidator', 'fightJwtEncoder', 'fightJwtDecoder',
            'fightValidation', 'fightRequest', 'fightResponse', 'fightEventMapper', 'fightEventStore',
            'fightSynchronousCommandBus', 'fightSynchronousEventDispatcher', 'fightCommandMessageHandler',
            'fightEventMessageHandler',
            'fightHttpClient', 'fightPsr18Client', 'fightMessageFactory', 'fightUriFactory', 'fightFileStorage',
            'fightFileTransfer', 'fightProcessRunner', 'fightScheduler', 'fightAuditLog', 'fightMetrics',
            'fightHealthReporter', 'fightSmsTransport', 'fightTwilioClient', 'fightMercureHub', 'fightPublisher',
            'fightPrivatePublisher',
        ];

        foreach ($services as $service) {
            $this->assertIsObject(service($service), $service);
        }
    }

    public function test_queue_command_event_failure_retry_and_completion_fan_out(): void
    {
        $events = [];
        foreach ([QueueEventManager::JOB_PUSHED, QueueEventManager::JOB_FAILED, QueueEventManager::JOB_PROCESSING_COMPLETED] as $eventName) {
            Events::on($eventName, static function (QueueEvent $event) use (&$events): void {
                $events[] = $event->getType();
            });
        }

        service('fightCommandBus')->dispatch(CommandMessage::create(new ReceiptCommand()));
        service('fightEventDispatcher')->dispatch(EventMessage::create(new ReceiptEvent()));

        $queue = service('queue');
        $command = $queue->pop('fight', ['default']);
        $this->assertNotNull($command);
        $queue->failed($command, new \RuntimeException('expected failure'), true);
        $this->assertSame(1, $queue->retry(null, 'fight'));

        $retried = $queue->pop('fight', ['default']);
        $this->assertNotNull($retried);
        QueueEventManager::jobFailed('database', 'fight', $retried, new \RuntimeException('expected failure'));
        $queue->done($retried);
        QueueEventManager::jobProcessingCompleted('database', 'fight', $retried, 0.01);

        $event = $queue->pop('fight', ['default']);
        $this->assertNotNull($event);
        $queue->done($event);

        $this->assertSame([
            QueueEventManager::JOB_PUSHED,
            QueueEventManager::JOB_PUSHED,
            QueueEventManager::JOB_PUSHED,
            QueueEventManager::JOB_FAILED,
            QueueEventManager::JOB_PROCESSING_COMPLETED,
        ], $events);
    }
}

final class ReceiptCommand implements Command
{
    public static function fromArray(array $data): static { return new self(); }
    public function toArray(): array { return []; }
}

final class ReceiptEvent implements Event
{
    public static function fromArray(array $data): static { return new self(); }
    public function toArray(): array { return []; }
}
