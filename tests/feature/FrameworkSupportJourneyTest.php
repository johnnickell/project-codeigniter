<?php

declare(strict_types=1);

use CodeIgniter\Config\Services as CoreServices;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Queue\Events\QueueEvent;
use CodeIgniter\Queue\Events\QueueEventManager;
use CodeIgniter\Test\CIUnitTestCase;
use Fight\Common\Adapter\HttpClient\Guzzle\GuzzleClient;
use Fight\Common\Adapter\Http\CodeIgniter\JSendResponse;
use Fight\Common\Adapter\Messaging\Handler\CommandMessageHandler;
use Fight\Common\Adapter\Messaging\Handler\EventMessageHandler;
use Fight\Common\Adapter\Messaging\Event\Sync\SimpleEventDispatcher;
use Fight\Common\Application\Observability\HealthCheck;
use Fight\Common\Application\Process\ProcessBuilder;
use Fight\Common\Application\Sms\Message\SmsMessage;
use Fight\Common\Application\Messaging\Command\SynchronousCommandBus;
use Fight\Common\Application\Messaging\Event\EventSubscriber;
use Fight\Common\Domain\Observability\AuditEntry;
use Fight\Common\Domain\Observability\HealthResult;
use Fight\Common\Domain\Observability\HealthStatus;
use Fight\Common\Domain\Messaging\Command\Command;
use Fight\Common\Domain\Messaging\Command\CommandMessage;
use Fight\Common\Domain\Messaging\Event\Event;
use Fight\Common\Domain\Messaging\Event\EventMessage;
use Fight\Common\Domain\Messaging\MessageId;
use Fight\Common\Domain\Messaging\Meta;
use Fight\Common\Domain\EventSourcing\Exception\EventMappingException;
use Fight\Common\Domain\EventSourcing\StreamId;
use Fight\Common\Domain\Exception\LookupException;

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

    public function test_default_request_event_store_and_synchronous_messaging_services_are_safe_and_configurable(): void
    {
        $request = service('fightRequest');
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('/', $request->getUri()->getPath());

        $eventStore = service('fightEventStore');
        $this->assertSame([], [...$eventStore->readAllAfter(0, 10)]);
        try {
            $eventStore->append(
                new StreamId('receipt', 'unconfigured-domain'),
                0,
                [EventMessage::create(new ReceiptEvent('requires-project-mapping'))],
            );
            self::fail('The starter must require project-owned event mappings before persisting domain events.');
        } catch (EventMappingException $exception) {
            $this->assertSame('Unknown event class: ' . ReceiptEvent::class . '.', $exception->getMessage());
        }
        $this->assertSame([], [...$eventStore->readAllAfter(0, 10)]);

        try {
            service('fightSynchronousCommandBus')->execute(new ReceiptCommand('requires-project-handler'));
            self::fail('The starter must require a project-owned command handler before dispatching a domain command.');
        } catch (LookupException $exception) {
            $this->assertSame('Handler not defined for command: ' . ReceiptCommand::class, $exception->getMessage());
        }

        service('fightSynchronousEventDispatcher')->trigger(new ReceiptEvent('no-project-subscribers'));
        $this->addToAssertionCount(1);
    }

    public function test_security_validation_and_native_http_profile_services_have_consumer_outcomes(): void
    {
        $password = 'receipt-password';
        $hash = service('fightPasswordHasher')->hash($password);
        $this->assertTrue(service('fightPasswordValidator')->validate($password, $hash));
        $this->assertFalse(service('fightPasswordValidator')->validate('wrong-password', $hash));

        $token = service('fightJwtEncoder')->encode(
            ['sub' => 'receipt-user', 'profile' => 'codeigniter'],
            new \DateTimeImmutable('2030-01-01T00:00:00+00:00'),
        );
        $claims = service('fightJwtDecoder')->decode($token);
        $this->assertSame('receipt-user', $claims['sub']);
        $this->assertSame('codeigniter', $claims['profile']);

        $validation = service('fightValidation');
        $validation->setRules(['receipt' => 'required|min_length[7]']);
        $this->assertTrue($validation->run(['receipt' => 'approved']));
        $this->assertFalse($validation->run(['receipt' => 'no']));

        $request = service('fightMessageFactory')->createRequest('GET', service('fightUriFactory')->createUri('https://profile.test/receipt'));
        $mockTransport = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(202, ['X-Profile' => 'native'], 'http-response'),
            new \GuzzleHttp\Psr7\Response(203, ['X-Profile' => 'psr18'], 'psr18-response'),
        ]);
        CoreServices::injectMock('fightHttpClient', new GuzzleClient(new \GuzzleHttp\Client(['handler' => $mockTransport])));

        $httpResponse = service('fightHttpClient')->send($request);
        $this->assertSame(202, $httpResponse->getStatusCode());
        $this->assertSame('native', $httpResponse->getHeaderLine('X-Profile'));
        $this->assertSame('http-response', (string) $httpResponse->getBody());

        $psr18Response = service('fightPsr18Client', false)->sendRequest($request);
        $this->assertSame(203, $psr18Response->getStatusCode());
        $this->assertSame('psr18-response', (string) $psr18Response->getBody());
    }

    public function test_storage_transfer_process_and_scheduler_profile_services_have_consumer_outcomes(): void
    {
        $storage = service('fightFileStorage');
        $storage->putFile('journey/receipt.txt', 'stored');
        $storage->copyFile('journey/receipt.txt', 'journey/copy.txt');
        $storage->moveFile('journey/copy.txt', 'journey/moved.txt');
        $this->assertTrue($storage->hasFile('journey/moved.txt'));
        $this->assertSame('stored', $storage->getFileContents('journey/moved.txt'));
        $this->assertSame(6, $storage->size('journey/moved.txt'));
        $storage->removeFile('journey/receipt.txt');
        $storage->removeFile('journey/moved.txt');

        $transfer = service('fightFileTransfer');
        $transfer->sendFile('/receipt.txt', 'ignored-by-null-fallback');
        $this->assertSame('', $transfer->retrieveFileContents('/receipt.txt'));
        $this->assertSame([], $transfer->readDirectory('/'));

        $output = '';
        $process = ProcessBuilder::create([PHP_BINARY, '-r', 'echo "process-complete";'])
            ->stdout(static function (string $chunk) use (&$output): void { $output .= $chunk; })
            ->getProcess();
        service('fightProcessRunner')->attach($process);
        service('fightProcessRunner')->run();
        $this->assertSame('process-complete', $output);

        $ran = false;
        $scheduler = service('fightScheduler');
        $lockPath = WRITEPATH . 'receipt-scheduled-job.lock';
        @unlink($lockPath);
        try {
            $scheduler->addJob('receipt-scheduled-job', static fn (): bool => true, static function () use (&$ran): void { $ran = true; });
            $scheduler->run();
            $this->assertTrue($ran);
        } finally {
            @unlink($lockPath);
        }
    }

    public function test_observability_sms_and_mercure_profile_services_have_safe_consumer_outcomes(): void
    {
        $logger = new RecordingProfileLogger();
        CoreServices::injectMock('logger', $logger);
        service('fightAuditLog', false)->record(AuditEntry::record('receipt-user', 'profile-verified', ['source' => 'journey']));
        $this->assertSame('info', $logger->entries[0]['level']);
        $this->assertSame('audit', $logger->entries[0]['message']);
        $this->assertSame('receipt-user', $logger->entries[0]['context']['actor']);
        $this->assertSame('profile-verified', $logger->entries[0]['context']['action']);
        $this->assertSame(['source' => 'journey'], $logger->entries[0]['context']['context']);

        $metrics = new RecordingProfileMetrics();
        CoreServices::injectMock('fightMetrics', $metrics);
        service('fightMetrics')->increment('profile.completed', ['framework' => 'codeigniter']);
        service('fightMetrics')->gauge('profile.services', 1.0, ['framework' => 'codeigniter']);
        service('fightMetrics')->histogram('profile.duration', 2.0, ['framework' => 'codeigniter']);
        $this->assertSame([
            ['increment', 'profile.completed', null, ['framework' => 'codeigniter']],
            ['gauge', 'profile.services', 1.0, ['framework' => 'codeigniter']],
            ['histogram', 'profile.duration', 2.0, ['framework' => 'codeigniter']],
        ], $metrics->measurements);

        $health = service('fightHealthReporter');
        $health->addCheck(new class implements HealthCheck {
            public function name(): string { return 'receipt'; }
            public function check(): HealthResult { return new HealthResult('receipt', HealthStatus::healthy(), 'available'); }
        });
        $report = $health->report();
        $this->assertTrue($report->isHealthy());
        $this->assertSame('receipt', $report->results()[0]->name());
        $this->assertSame('available', $report->results()[0]->message());

        $this->assertInstanceOf(\Fight\Common\Adapter\Sms\Null\NullSmsTransport::class, service('fightSmsTransport', false));

        $sms = new RecordingProfileSmsTransport();
        CoreServices::injectMock('fightSmsTransport', $sms);
        service('fightSmsTransport')->send(SmsMessage::create('+15550000001', '+15550000002')->setBody('safe fallback'));
        $this->assertSame([['to' => '+15550000001', 'from' => '+15550000002', 'body' => 'safe fallback']], $sms->messages);

        $hub = new RecordingProfileHub();
        CoreServices::injectMock('fightMercureHub', $hub);
        service('fightPublisher', false)->push('https://profile.test/public', 'public update');
        service('fightPrivatePublisher', false)->pushPrivate('https://profile.test/private', 'private update');
        $this->assertSame([
            ['topics' => ['https://profile.test/public'], 'data' => 'public update', 'private' => false],
            ['topics' => ['https://profile.test/private'], 'data' => 'private update', 'private' => true],
        ], $hub->updates);
    }

    public function test_production_sms_profile_composes_the_twilio_adapter_without_a_network_request(): void
    {
        $environment = [
            'CI_ENVIRONMENT=production',
            'fightcommon_jwtSecret=' . escapeshellarg(str_repeat('a', 64)),
            'fightcommon_mercureUrl=' . escapeshellarg('https://mercure.example.test/.well-known/mercure'),
            'fightcommon_mercureJwt=' . escapeshellarg('header.payload.signature'),
            'fightcommon_twilioAccountSid=' . escapeshellarg('AC00000000000000000000000000000000'),
            'fightcommon_twilioAuthToken=' . escapeshellarg('test-auth-token'),
        ];

        exec(
            implode(' ', $environment) . ' ' . escapeshellarg(PHP_BINARY) . ' scripts/verify-production-framework-support-profile.php --assert-twilio 2>&1',
            $lines,
            $status,
        );

        $this->assertSame(0, $status);
        $this->assertContains('Production Twilio SMS adapter used the injected HTTP client.', $lines);
    }

    public function test_database_queue_jobs_deliver_complete_command_and_retry_event_envelopes(): void
    {
        $commandBus = new RecordingSynchronousCommandBus();
        $eventDeliveries = [];
        $queueEvents = [];
        $eventDispatcher = new SimpleEventDispatcher();
        $eventDispatcher->register(new RecordingReceiptEventSubscriber('first', $eventDeliveries));
        $eventDispatcher->register(new RecordingReceiptEventSubscriber('second', $eventDeliveries));

        $failFirstEventAttempt = true;
        $eventDispatcher->register(new FailFirstReceiptEventSubscriber($failFirstEventAttempt));

        CoreServices::injectMock('fightCommandMessageHandler', new CommandMessageHandler($commandBus));
        CoreServices::injectMock('fightEventMessageHandler', new EventMessageHandler($eventDispatcher));

        $queueEventListener = static function (QueueEvent $event) use (&$queueEvents): void {
            $queueEvents[] = [
                'type' => $event->getType(),
                'queue' => $event->getQueue(),
                'job_class' => $event->getJobClass(),
                'exception' => $event->getExceptionMessage(),
            ];
        };
        $queueEventTypes = [
            QueueEventManager::JOB_PUSHED,
            QueueEventManager::JOB_PROCESSING_STARTED,
            QueueEventManager::JOB_PROCESSING_COMPLETED,
            QueueEventManager::JOB_FAILED,
            QueueEventManager::WORKER_STARTED,
            QueueEventManager::WORKER_STOPPED,
        ];

        foreach ($queueEventTypes as $queueEventType) {
            Events::on($queueEventType, $queueEventListener);
        }

        $commandMessage = new CommandMessage(
            MessageId::fromString('11111111-1111-4111-8111-111111111111'),
            new \DateTimeImmutable('2026-09-03T12:34:56+00:00'),
            new ReceiptCommand('command-value'),
            Meta::create(['trace_id' => 'trace-command', 'source' => 'queue-journey']),
        );
        $eventMessage = new EventMessage(
            MessageId::fromString('22222222-2222-4222-8222-222222222222'),
            new \DateTimeImmutable('2026-09-03T12:35:00+00:00'),
            new ReceiptEvent('event-value'),
            Meta::create(['trace_id' => 'trace-event', 'attempt' => 1]),
        );

        try {
            service('fightCommandBus')->dispatch($commandMessage);
            service('fightEventDispatcher')->dispatch($eventMessage);

            $this->assertSame(EXIT_SUCCESS, service('commands')->run('queue:work', [
                'fight',
                'max-jobs' => 2,
            ]));
            $this->assertSame(1, db_connect()->table('queue_jobs_failed')->where('queue', 'fight')->countAllResults());

            $this->assertSame(EXIT_SUCCESS, service('commands')->run('queue:retry', [
                'all',
                'queue' => 'fight',
            ]));
            $this->assertSame(EXIT_SUCCESS, service('commands')->run('queue:work', [
                'fight',
                'max-jobs' => 1,
            ]));
            $this->assertSame(0, db_connect()->table('queue_jobs_failed')->where('queue', 'fight')->countAllResults());
            $this->assertSame(0, db_connect()->table('queue_jobs')->where('queue', 'fight')->countAllResults());
        } finally {
            foreach ($queueEventTypes as $queueEventType) {
                Events::removeListener($queueEventType, $queueEventListener);
            }
        }

        $this->assertSame([[
            'id' => '11111111-1111-4111-8111-111111111111',
            'timestamp' => '2026-09-03T12:34:56+00:00',
            'payload_type' => ReceiptCommand::class,
            'payload' => ['value' => 'command-value'],
            'meta' => ['trace_id' => 'trace-command', 'source' => 'queue-journey'],
        ]], $commandBus->deliveries);

        $this->assertSame([
            ['subscriber' => 'first', 'id' => '22222222-2222-4222-8222-222222222222', 'timestamp' => '2026-09-03T12:35:00+00:00', 'payload_type' => ReceiptEvent::class, 'payload' => ['value' => 'event-value'], 'meta' => ['trace_id' => 'trace-event', 'attempt' => 1]],
            ['subscriber' => 'second', 'id' => '22222222-2222-4222-8222-222222222222', 'timestamp' => '2026-09-03T12:35:00+00:00', 'payload_type' => ReceiptEvent::class, 'payload' => ['value' => 'event-value'], 'meta' => ['trace_id' => 'trace-event', 'attempt' => 1]],
            ['subscriber' => 'first', 'id' => '22222222-2222-4222-8222-222222222222', 'timestamp' => '2026-09-03T12:35:00+00:00', 'payload_type' => ReceiptEvent::class, 'payload' => ['value' => 'event-value'], 'meta' => ['trace_id' => 'trace-event', 'attempt' => 1]],
            ['subscriber' => 'second', 'id' => '22222222-2222-4222-8222-222222222222', 'timestamp' => '2026-09-03T12:35:00+00:00', 'payload_type' => ReceiptEvent::class, 'payload' => ['value' => 'event-value'], 'meta' => ['trace_id' => 'trace-event', 'attempt' => 1]],
        ], $eventDeliveries);

        $this->assertSame([
            ['type' => QueueEventManager::JOB_PUSHED, 'queue' => 'fight', 'job_class' => 'fight-command', 'exception' => null],
            ['type' => QueueEventManager::JOB_PUSHED, 'queue' => 'fight', 'job_class' => 'fight-event', 'exception' => null],
            ['type' => QueueEventManager::WORKER_STARTED, 'queue' => 'fight', 'job_class' => null, 'exception' => null],
            ['type' => QueueEventManager::JOB_PROCESSING_STARTED, 'queue' => 'fight', 'job_class' => 'fight-command', 'exception' => null],
            ['type' => QueueEventManager::JOB_PROCESSING_COMPLETED, 'queue' => 'fight', 'job_class' => 'fight-command', 'exception' => null],
            ['type' => QueueEventManager::JOB_PROCESSING_STARTED, 'queue' => 'fight', 'job_class' => 'fight-event', 'exception' => null],
            ['type' => QueueEventManager::JOB_FAILED, 'queue' => 'fight', 'job_class' => 'fight-event', 'exception' => 'Event dispatch failed in 1 handler(s).'],
            ['type' => QueueEventManager::WORKER_STOPPED, 'queue' => 'fight', 'job_class' => null, 'exception' => null],
            ['type' => QueueEventManager::JOB_PUSHED, 'queue' => 'fight', 'job_class' => 'fight-event', 'exception' => null],
            ['type' => QueueEventManager::WORKER_STARTED, 'queue' => 'fight', 'job_class' => null, 'exception' => null],
            ['type' => QueueEventManager::JOB_PROCESSING_STARTED, 'queue' => 'fight', 'job_class' => 'fight-event', 'exception' => null],
            ['type' => QueueEventManager::JOB_PROCESSING_COMPLETED, 'queue' => 'fight', 'job_class' => 'fight-event', 'exception' => null],
            ['type' => QueueEventManager::WORKER_STOPPED, 'queue' => 'fight', 'job_class' => null, 'exception' => null],
        ], $queueEvents);
    }
}

final class ReceiptCommand implements Command
{
    public function __construct(public readonly string $value) {}
    public static function fromArray(array $data): static { return new self($data['value']); }
    public function toArray(): array { return ['value' => $this->value]; }
}

final class ReceiptEvent implements Event
{
    public function __construct(public readonly string $value) {}
    public static function fromArray(array $data): static { return new self($data['value']); }
    public function toArray(): array { return ['value' => $this->value]; }
}

final class RecordingSynchronousCommandBus implements SynchronousCommandBus
{
    /** @var list<array<string, mixed>> */
    public array $deliveries = [];

    public function execute(Command $command): void
    {
        $this->dispatch(CommandMessage::create($command));
    }

    public function dispatch(CommandMessage $commandMessage): void
    {
        $this->deliveries[] = receiptMessageSnapshot($commandMessage);
    }
}

final class RecordingReceiptEventSubscriber implements EventSubscriber
{
    /** @param list<array<string, mixed>> $deliveries */
    public function __construct(private readonly string $name, private array &$deliveries) {}

    public static function eventRegistration(): array
    {
        return [ReceiptEvent::class => 'record'];
    }

    public function record(EventMessage $eventMessage): void
    {
        $this->deliveries[] = ['subscriber' => $this->name] + receiptMessageSnapshot($eventMessage);
    }
}

final class FailFirstReceiptEventSubscriber implements EventSubscriber
{
    public function __construct(private bool &$failFirstAttempt) {}

    public static function eventRegistration(): array
    {
        return [ReceiptEvent::class => ['fail', -100]];
    }

    public function fail(EventMessage $eventMessage): void
    {
        if ($this->failFirstAttempt) {
            $this->failFirstAttempt = false;
            throw new \RuntimeException('retry this event');
        }
    }
}

/** @return array<string, mixed> */
function receiptMessageSnapshot(CommandMessage|EventMessage $message): array
{
    return [
        'id' => $message->id()->toString(),
        'timestamp' => $message->timestamp()->format('Y-m-d\\TH:i:sP'),
        'payload_type' => $message->payloadType()->toClassName(),
        'payload' => $message->payload()->toArray(),
        'meta' => $message->meta()->toArray(),
    ];
}

final class RecordingProfileLogger extends \Psr\Log\AbstractLogger
{
    /** @var list<array{level: mixed, message: string|\Stringable, context: array<mixed>}> */
    public array $entries = [];

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $this->entries[] = [
            'level' => $level,
            'message' => $message,
            'context' => $context,
        ];
    }
}

final class RecordingProfileHub implements \Symfony\Component\Mercure\HubInterface
{
    /** @var list<array{topics: list<string>, data: string, private: bool}> */
    public array $updates = [];

    public function getPublicUrl(): string
    {
        return 'https://profile.test/.well-known/mercure';
    }

    public function getFactory(): ?\Symfony\Component\Mercure\Jwt\TokenFactoryInterface
    {
        return null;
    }

    public function publish(\Symfony\Component\Mercure\Update $update): string
    {
        $this->updates[] = [
            'topics' => $update->getTopics(),
            'data' => $update->getData(),
            'private' => $update->isPrivate(),
        ];

        return 'profile-update';
    }
}

final class RecordingProfileMetrics implements \Fight\Common\Application\Observability\MetricsCollector
{
    /** @var list<array{string, string, float|null, array<string, string>}> */
    public array $measurements = [];

    public function increment(string $metric, array $tags = []): void
    {
        $this->measurements[] = ['increment', $metric, null, $tags];
    }

    public function gauge(string $metric, float $value, array $tags = []): void
    {
        $this->measurements[] = ['gauge', $metric, $value, $tags];
    }

    public function histogram(string $metric, float $value, array $tags = []): void
    {
        $this->measurements[] = ['histogram', $metric, $value, $tags];
    }
}

final class RecordingProfileSmsTransport implements \Fight\Common\Application\Sms\Transport\SmsTransport
{
    /** @var list<array{to: string, from: string, body: string|null}> */
    public array $messages = [];

    public function send(SmsMessage $message): void
    {
        $this->messages[] = [
            'to' => $message->getTo(),
            'from' => $message->getFrom(),
            'body' => $message->getBody(),
        ];
    }
}
