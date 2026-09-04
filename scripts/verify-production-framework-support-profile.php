<?php

declare(strict_types=1);

use CodeIgniter\Boot;
use CodeIgniter\Config\Services as CoreServices;
use Config\Paths;
use Fight\Common\Application\Observability\HealthCheck;
use Fight\Common\Application\Observability\MetricsCollector;
use Fight\Common\Application\Process\ProcessBuilder;
use Fight\Common\Application\Sms\Message\SmsMessage;
use Fight\Common\Application\Sms\Transport\SmsTransport;
use Fight\Common\Domain\EventSourcing\Exception\EventMappingException;
use Fight\Common\Domain\EventSourcing\StreamId;
use Fight\Common\Domain\Exception\LookupException;
use Fight\Common\Domain\Messaging\Command\Command;
use Fight\Common\Domain\Messaging\Event\Event;
use Fight\Common\Domain\Messaging\Event\EventMessage;
use Fight\Common\Domain\Observability\AuditEntry;
use Fight\Common\Domain\Observability\HealthResult;
use Fight\Common\Domain\Observability\HealthStatus;
use Symfony\Component\Mercure\Hub;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

$projectRoot = dirname(__DIR__);
chdir($projectRoot);

defined('FCPATH') || define('FCPATH', $projectRoot . '/public/');
defined('ENVIRONMENT') || define('ENVIRONMENT', 'production');

require $projectRoot . '/app/Config/Paths.php';

$paths = new Paths();
require $paths->systemDirectory . '/Boot.php';
Boot::bootConsole($paths);

try {
    $jwtEncoder = service('fightJwtEncoder');
    $jwtDecoder = service('fightJwtDecoder');
    service('fightTwilioClient');
    $configuredHub = service('fightMercureHub');
    productionAssert($configuredHub instanceof Hub, 'Production profile must construct a configured Mercure Hub.');

    $token = $jwtEncoder->encode(['sub' => 'production-profile'], new DateTimeImmutable('2030-01-01T00:00:00+00:00'));
    productionAssert('production-profile' === $jwtDecoder->decode($token)['sub'], 'JWT round trip failed.');

    $validation = service('fightValidation');
    $validation->setRules(['profile' => 'required']);
    productionAssert($validation->run(['profile' => 'verified']), 'Validation service failed.');
    productionAssert('CLI' === service('fightRequest')->getMethod(), 'Request service did not boot as a CLI request.');
    productionAssert('/' === service('fightRequest')->getUri()->getPath(), 'Request service did not provide the root URI.');

    $cacheKey = 'production-profile-' . bin2hex(random_bytes(4));
    productionAssert('cached' === service('fightCache')->read($cacheKey, static fn (): string => 'cached', 60), 'Cache service failed.');
    productionAssert('Fight production receipt' === service('fightTemplateEngine')->render('receipt.twig', ['framework' => 'production']), 'Template service failed.');
    $mail = service('fightMailFactory')->createMessage()
        ->setSubject('Production profile')
        ->addFrom('profile@example.test')
        ->addTo('profile@example.test')
        ->addContent('safe local mail transport', 'text/plain');
    service('fightMailTransport')->send($mail);

    $filesystemPath = WRITEPATH . 'production-profile-' . bin2hex(random_bytes(4));
    try {
        service('fightFilesystem')->mkdir($filesystemPath);
        service('fightFilesystem')->put($filesystemPath . '/receipt.txt', 'verified');
        productionAssert('verified' === service('fightFilesystem')->get($filesystemPath . '/receipt.txt'), 'Filesystem service failed.');

        $storage = service('fightFileStorage');
        $storageKey = 'production-profile/' . bin2hex(random_bytes(4)) . '.txt';
        $storage->putFile($storageKey, 'stored');
        productionAssert('stored' === $storage->getFileContents($storageKey), 'File storage service failed.');
        $storage->removeFile($storageKey);
    } finally {
        service('fightFilesystem')->remove($filesystemPath);
    }

    service('fightFileTransfer')->sendFile('/production-profile.txt', 'safe fallback');
    productionAssert('' === service('fightFileTransfer')->retrieveFileContents('/production-profile.txt'), 'File transfer fallback was not safe.');

    $responses = new GuzzleHttp\Handler\MockHandler([
        new GuzzleHttp\Psr7\Response(202, [], 'http'),
        new GuzzleHttp\Psr7\Response(203, [], 'psr18'),
    ]);
    CoreServices::injectMock('fightHttpClient', new Fight\Common\Adapter\HttpClient\Guzzle\GuzzleClient(new GuzzleHttp\Client(['handler' => $responses])));
    $request = service('fightMessageFactory')->createRequest('GET', service('fightUriFactory')->createUri('https://profile.test/receipt'));
    productionAssert(202 === service('fightHttpClient')->send($request)->getStatusCode(), 'HTTP client service failed.');
    productionAssert(203 === service('fightPsr18Client', false)->sendRequest($request)->getStatusCode(), 'PSR-18 client service failed.');

    $processOutput = '';
    $process = ProcessBuilder::create([PHP_BINARY, '-r', 'echo "production-process";'])
        ->stdout(static function (string $chunk) use (&$processOutput): void { $processOutput .= $chunk; })
        ->getProcess();
    service('fightProcessRunner')->attach($process);
    service('fightProcessRunner')->run();
    productionAssert('production-process' === $processOutput, 'Process runner failed.');

    $scheduled = false;
    $scheduler = service('fightScheduler');
    $scheduledJob = 'production-profile-' . bin2hex(random_bytes(4));
    $scheduledLock = WRITEPATH . $scheduledJob . '.lock';
    @unlink($scheduledLock);
    try {
        $scheduler->addJob($scheduledJob, static fn (): bool => true, static function () use (&$scheduled): void { $scheduled = true; });
        $scheduler->run();
        productionAssert($scheduled, 'Scheduler did not execute its due job.');
    } finally {
        @unlink($scheduledLock);
    }

    service('fightAuditLog')->record(AuditEntry::record('production-profile', 'verified'));
    $metrics = new class implements MetricsCollector {
        /** @var list<array{string, array<string, string>}> */
        public array $increments = [];
        public function increment(string $metric, array $tags = []): void { $this->increments[] = [$metric, $tags]; }
        public function gauge(string $metric, float $value, array $tags = []): void {}
        public function histogram(string $metric, float $value, array $tags = []): void {}
    };
    CoreServices::injectMock('fightMetrics', $metrics);
    service('fightMetrics')->increment('profile.completed', ['environment' => 'production']);
    productionAssert([['profile.completed', ['environment' => 'production']]] === $metrics->increments, 'Metrics service did not record the measurement.');

    $health = service('fightHealthReporter');
    $health->addCheck(new class implements HealthCheck {
        public function name(): string { return 'production-profile'; }
        public function check(): HealthResult { return new HealthResult('production-profile', HealthStatus::healthy(), 'available'); }
    });
    productionAssert($health->report()->isHealthy(), 'Health reporter failed.');

    $sms = new class implements SmsTransport {
        /** @var list<string|null> */
        public array $bodies = [];
        public function send(SmsMessage $message): void { $this->bodies[] = $message->getBody(); }
    };
    CoreServices::injectMock('fightSmsTransport', $sms);
    service('fightSmsTransport')->send(SmsMessage::create('+15550000001', '+15550000002')->setBody('production fallback'));
    productionAssert(['production fallback'] === $sms->bodies, 'SMS service did not receive the local message.');

    try {
        service('fightEventStore')->append(new StreamId('profile', 'default'), 0, [EventMessage::create(new class('mapping-required') implements Event {
            public function __construct(public readonly string $value) {}
            public static function fromArray(array $data): static { return new self($data['value']); }
            public function toArray(): array { return ['value' => $this->value]; }
        })]);
        throw new RuntimeException('Event store accepted an unmapped application event.');
    } catch (EventMappingException) {
        productionAssert([] === [...service('fightEventStore')->readAllAfter(0, 1)], 'Event store wrote an unmapped event.');
    }
    try {
        service('fightSynchronousCommandBus')->execute(new class implements Command {
            public static function fromArray(array $data): static { return new self(); }
            public function toArray(): array { return []; }
        });
        throw new RuntimeException('Synchronous command bus accepted an unhandled command.');
    } catch (LookupException) {
        // Application command handlers remain project-owned and must be registered explicitly.
    }
    service('fightSynchronousEventDispatcher')->trigger(new class('subscribers-optional') implements Event {
        public function __construct(public readonly string $value) {}
        public static function fromArray(array $data): static { return new self($data['value']); }
        public function toArray(): array { return ['value' => $this->value]; }
    });

    $recordingHub = new class implements HubInterface {
        /** @var list<array{string, string, bool}> */
        public array $updates = [];
        public function getPublicUrl(): string { return 'https://profile.test/.well-known/mercure'; }
        public function getFactory(): ?Symfony\Component\Mercure\Jwt\TokenFactoryInterface { return null; }
        public function publish(Update $update): string
        {
            $this->updates[] = [$update->getTopics()[0], $update->getData(), $update->isPrivate()];
            return 'production-profile-update';
        }
    };
    CoreServices::injectMock('fightMercureHub', $recordingHub);
    service('fightPublisher', false)->push('https://profile.test/public', 'public profile');
    service('fightPrivatePublisher', false)->pushPrivate('https://profile.test/private', 'private profile');
    productionAssert([
        ['https://profile.test/public', 'public profile', false],
        ['https://profile.test/private', 'private profile', true],
    ] === $recordingHub->updates, 'Publication services did not pass updates through the registered hub.');
} catch (RuntimeException $exception) {
    fwrite(STDOUT, "Production profile correctly rejected unsafe configuration: {$exception->getMessage()}\n");

    exit(1);
}

fwrite(STDOUT, "Production Fight Common profile booted and exercised with explicit safe configuration.\n");

function productionAssert(bool $condition, string $message): void
{
    if (! $condition) {
        throw new RuntimeException($message);
    }
}
