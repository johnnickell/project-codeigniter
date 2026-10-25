<?php

declare(strict_types=1);

namespace Config;

use App\Services\StarterGreeting;
use CodeIgniter\Config\BaseService;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Validation\ValidationInterface;
use Fight\Common\Adapter\Auth\Security\JwtDecoder;
use Fight\Common\Adapter\Auth\Security\JwtEncoder;
use Fight\Common\Adapter\Cache\CodeIgniter\CodeIgniterCache;
use Fight\Common\Adapter\Messaging\CodeIgniter\QueueCommandBus;
use Fight\Common\Adapter\Messaging\CodeIgniter\QueueEventDispatcher;
use Fight\Common\Adapter\Messaging\Command\Sync\Routing\InMemoryCommandRouter;
use Fight\Common\Adapter\Messaging\Command\Sync\RoutingCommandBus;
use Fight\Common\Adapter\Messaging\Event\Sync\SimpleEventDispatcher;
use Fight\Common\Adapter\Messaging\Handler\CommandMessageHandler;
use Fight\Common\Adapter\Messaging\Handler\EventMessageHandler;
use Fight\Common\Adapter\Persistence\CodeIgniter\CodeIgniterTransactionalUnitOfWork;
use Fight\Common\Adapter\Routing\CodeIgniter\CodeIgniterUrlGenerator;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\CacheServices;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\FilesystemServices;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\MailServices;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\MessagingServices;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\PersistenceServices;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\RoutingServices;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\TemplateServices;
use Fight\Common\Application\Auth\Security\PasswordHasher;
use Fight\Common\Application\Auth\Security\PasswordValidator;
use Fight\Common\Application\FileStorage\FileStorage;
use Fight\Common\Application\Filesystem\Filesystem;
use Fight\Common\Application\FileTransfer\Transport\FileTransport;
use Fight\Common\Application\HttpClient\Message\MessageFactory;
use Fight\Common\Application\HttpClient\Message\UriFactory;
use Fight\Common\Application\HttpClient\Transport\HttpClient;
use Fight\Common\Application\Mail\Message\MailFactory;
use Fight\Common\Application\Mail\Transport\MailTransport;
use Fight\Common\Application\Messaging\Command\SynchronousCommandBus;
use Fight\Common\Application\Messaging\Event\SynchronousEventDispatcher;
use Fight\Common\Application\Observability\AuditLog;
use Fight\Common\Application\Observability\HealthAggregator;
use Fight\Common\Application\Observability\MetricsCollector;
use Fight\Common\Application\Process\ProcessRunner;
use Fight\Common\Application\Scheduler\Scheduler;
use Fight\Common\Application\Sms\Transport\SmsTransport;
use Fight\Common\Application\Socket\PrivatePublisher;
use Fight\Common\Application\Socket\Publisher;
use Fight\Common\Application\Templating\TemplateEngine;
use Fight\Common\Domain\EventSourcing\EventMapper;
use Fight\Common\Domain\EventSourcing\EventStore;
use Fight\Common\Domain\Value\DateTime\Timezone;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\NullTransport;
use Symfony\Component\Mercure\HubInterface;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

/**
 * Class Services
 *
 * Composes public package capabilities through native shared factories.
 * Request/response and selected database lifecycles remain framework-owned.
 */
class Services extends BaseService
{
    /**
     * Creates the presentation greeting
     */
    public static function starterGreeting(bool $getShared = true): StarterGreeting
    {
        if ($getShared) {
            return static::getSharedInstance('starterGreeting');
        }

        return new StarterGreeting();
    }

    /**
     * Creates the queued command pipeline
     */
    public static function fightCommandBus(bool $getShared = true): QueueCommandBus
    {
        if ($getShared) {
            return static::getSharedInstance('fightCommandBus');
        }

        return MessagingServices::queueCommandBus(service('queue'), 'fight', 'fight-command');
    }

    /**
     * Creates the queued event pipeline
     */
    public static function fightEventDispatcher(bool $getShared = true): QueueEventDispatcher
    {
        if ($getShared) {
            return static::getSharedInstance('fightEventDispatcher');
        }

        return MessagingServices::queueEventDispatcher(service('queue'), 'fight', 'fight-event');
    }

    /**
     * Creates the queue command delivery handler with the synchronous pipeline
     */
    public static function fightCommandMessageHandler(bool $getShared = true): CommandMessageHandler
    {
        if ($getShared) {
            return static::getSharedInstance('fightCommandMessageHandler');
        }

        return MessagingServices::commandMessageHandler(static::fightSynchronousCommandBus());
    }

    /**
     * Creates the queue event delivery handler with the synchronous pipeline
     */
    public static function fightEventMessageHandler(bool $getShared = true): EventMessageHandler
    {
        if ($getShared) {
            return static::getSharedInstance('fightEventMessageHandler');
        }

        return MessagingServices::eventMessageHandler(static::fightSynchronousEventDispatcher());
    }

    /**
     * Resolves native validation
     */
    public static function fightValidation(bool $getShared = true): ValidationInterface
    {
        if ($getShared) {
            return static::getSharedInstance('fightValidation');
        }

        return service('validation');
    }

    /**
     * Resolves the native request lifecycle
     */
    public static function fightRequest(bool $getShared = true): RequestInterface
    {
        if ($getShared) {
            return static::getSharedInstance('fightRequest');
        }

        return service('request');
    }

    /**
     * Resolves the native response lifecycle
     */
    public static function fightResponse(bool $getShared = true): ResponseInterface
    {
        if ($getShared) {
            return static::getSharedInstance('fightResponse');
        }

        return service('response');
    }

    /**
     * Creates the adapter over the selected shared native connection
     */
    public static function fightTransactionalUnitOfWork(bool $getShared = true): CodeIgniterTransactionalUnitOfWork
    {
        if ($getShared) {
            return static::getSharedInstance('fightTransactionalUnitOfWork');
        }

        return PersistenceServices::codeIgniterTransactionalUnitOfWork(db_connect());
    }

    /**
     * Creates the native cache adapter
     */
    public static function fightCache(bool $getShared = true): CodeIgniterCache
    {
        if ($getShared) {
            return static::getSharedInstance('fightCache');
        }

        return CacheServices::cache(cache());
    }

    /**
     * Creates the native named-route generator
     */
    public static function fightUrlGenerator(bool $getShared = true): CodeIgniterUrlGenerator
    {
        if ($getShared) {
            return static::getSharedInstance('fightUrlGenerator');
        }

        return RoutingServices::urlGenerator(service('routes'), config('App')->baseURL);
    }

    /**
     * Creates public mail messages
     */
    public static function fightMailFactory(bool $getShared = true): MailFactory
    {
        if ($getShared) {
            return static::getSharedInstance('fightMailFactory');
        }

        return MailServices::mailFactory();
    }

    /**
     * Creates a safe local mailer
     */
    public static function fightMailer(bool $getShared = true): MailerInterface
    {
        if ($getShared) {
            return static::getSharedInstance('fightMailer');
        }

        return new Mailer(new NullTransport());
    }

    /**
     * Creates the mail adapter over the registered mailer
     */
    public static function fightMailTransport(bool $getShared = true): MailTransport
    {
        if ($getShared) {
            return static::getSharedInstance('fightMailTransport');
        }

        return MailServices::mailTransport(static::fightMailer());
    }

    /**
     * Creates the template adapter over the registered Twig environment
     */
    public static function fightTemplateEngine(bool $getShared = true): TemplateEngine
    {
        if ($getShared) {
            return static::getSharedInstance('fightTemplateEngine');
        }

        return TemplateServices::templateEngine(static::fightTwigEnvironment());
    }

    /**
     * Creates the filesystem capability
     */
    public static function fightFilesystem(bool $getShared = true): Filesystem
    {
        if ($getShared) {
            return static::getSharedInstance('fightFilesystem');
        }

        return FilesystemServices::filesystem();
    }

    /**
     * Creates the public password hashing capability
     */
    public static function fightPasswordHasher(bool $getShared = true): PasswordHasher
    {
        if ($getShared) {
            return static::getSharedInstance('fightPasswordHasher');
        }

        return new \Fight\Common\Adapter\Auth\Security\PhpPasswordHasher(PASSWORD_DEFAULT);
    }

    /**
     * Creates the public password validation capability
     */
    public static function fightPasswordValidator(bool $getShared = true): PasswordValidator
    {
        if ($getShared) {
            return static::getSharedInstance('fightPasswordValidator');
        }

        return new \Fight\Common\Adapter\Auth\Security\PhpPasswordValidator(PASSWORD_DEFAULT);
    }

    /**
     * Creates a JWT encoder with environment-qualified credentials
     */
    public static function fightJwtEncoder(bool $getShared = true): JwtEncoder
    {
        if ($getShared) {
            return static::getSharedInstance('fightJwtEncoder');
        }

        return new JwtEncoder(config('FightCommon')->jwtSecretForEnvironment());
    }

    /**
     * Creates a JWT decoder with environment-qualified credentials
     */
    public static function fightJwtDecoder(bool $getShared = true): JwtDecoder
    {
        if ($getShared) {
            return static::getSharedInstance('fightJwtDecoder');
        }

        return new JwtDecoder(config('FightCommon')->jwtSecretForEnvironment());
    }

    /**
     * Creates the intentionally unconfigured event mapper
     */
    public static function fightEventMapper(bool $getShared = true): EventMapper
    {
        if ($getShared) {
            return static::getSharedInstance('fightEventMapper');
        }

        return new EventMapper([]);
    }

    /**
     * Creates the in-memory event store over the registered mapper
     */
    public static function fightEventStore(bool $getShared = true): EventStore
    {
        if ($getShared) {
            return static::getSharedInstance('fightEventStore');
        }

        return new \Fight\Common\Adapter\EventSourcing\InMemory\InMemoryEventStore(static::fightEventMapper());
    }

    /**
     * Creates the synchronous command pipeline over the registered router
     */
    public static function fightSynchronousCommandBus(bool $getShared = true): SynchronousCommandBus
    {
        if ($getShared) {
            return static::getSharedInstance('fightSynchronousCommandBus');
        }

        return new RoutingCommandBus(static::fightCommandRouter());
    }

    /**
     * Creates the synchronous event pipeline
     */
    public static function fightSynchronousEventDispatcher(bool $getShared = true): SynchronousEventDispatcher
    {
        if ($getShared) {
            return static::getSharedInstance('fightSynchronousEventDispatcher');
        }

        return new SimpleEventDispatcher();
    }

    /**
     * Creates the HTTP adapter over the registered provider client
     */
    public static function fightHttpClient(bool $getShared = true): HttpClient
    {
        if ($getShared) {
            return static::getSharedInstance('fightHttpClient');
        }

        return new \Fight\Common\Adapter\HttpClient\Guzzle\GuzzleClient(static::fightGuzzleClient());
    }

    /**
     * Creates the PSR-18 adapter over the registered HTTP capability
     */
    public static function fightPsr18Client(bool $getShared = true): ClientInterface
    {
        if ($getShared) {
            return static::getSharedInstance('fightPsr18Client');
        }

        return new \Fight\Common\Adapter\HttpClient\Psr18\Psr18Client(service('fightHttpClient'));
    }

    /**
     * Creates HTTP messages
     */
    public static function fightMessageFactory(bool $getShared = true): MessageFactory
    {
        if ($getShared) {
            return static::getSharedInstance('fightMessageFactory');
        }

        return new \Fight\Common\Adapter\HttpClient\Guzzle\GuzzleMessageFactory();
    }

    /**
     * Creates HTTP URIs
     */
    public static function fightUriFactory(bool $getShared = true): UriFactory
    {
        if ($getShared) {
            return static::getSharedInstance('fightUriFactory');
        }

        return new \Fight\Common\Adapter\HttpClient\Guzzle\GuzzleUriFactory();
    }

    /**
     * Creates file storage over the registered local filesystem
     */
    public static function fightFileStorage(bool $getShared = true): FileStorage
    {
        if ($getShared) {
            return static::getSharedInstance('fightFileStorage');
        }

        return new \Fight\Common\Adapter\FileStorage\FlysystemStorage(static::fightFlysystem());
    }

    /**
     * Creates the safe null file-transfer capability
     */
    public static function fightFileTransfer(bool $getShared = true): FileTransport
    {
        if ($getShared) {
            return static::getSharedInstance('fightFileTransfer');
        }

        return new \Fight\Common\Adapter\FileTransfer\Null\NullFileTransport();
    }

    /**
     * Creates process execution with the native logger
     */
    public static function fightProcessRunner(bool $getShared = true): ProcessRunner
    {
        if ($getShared) {
            return static::getSharedInstance('fightProcessRunner');
        }

        return new \Fight\Common\Adapter\Process\Symfony\SymfonyProcessRunner(service('logger'));
    }

    /**
     * Creates scheduling over the registered process runner
     */
    public static function fightScheduler(bool $getShared = true): Scheduler
    {
        if ($getShared) {
            return static::getSharedInstance('fightScheduler');
        }

        return Scheduler::withProcessRunner(
            new Timezone(config('FightCommon')->timezone),
            WRITEPATH,
            static::fightProcessRunner(),
            service('logger')
        );
    }

    /**
     * Creates audit recording with the native logger
     */
    public static function fightAuditLog(bool $getShared = true): AuditLog
    {
        if ($getShared) {
            return static::getSharedInstance('fightAuditLog');
        }

        return new \Fight\Common\Adapter\Observability\Audit\LoggingAuditLog(service('logger'));
    }

    /**
     * Creates the safe null metrics capability
     */
    public static function fightMetrics(bool $getShared = true): MetricsCollector
    {
        if ($getShared) {
            return static::getSharedInstance('fightMetrics');
        }

        return new \Fight\Common\Adapter\Observability\Metrics\NullMetricsCollector();
    }

    /**
     * Creates the health aggregator
     */
    public static function fightHealthReporter(bool $getShared = true): HealthAggregator
    {
        if ($getShared) {
            return static::getSharedInstance('fightHealthReporter');
        }

        return new \Fight\Common\Adapter\Observability\Health\HealthReporter();
    }

    /**
     * Creates the production SMS adapter or safe local null transport
     */
    public static function fightSmsTransport(bool $getShared = true): SmsTransport
    {
        if ($getShared) {
            return static::getSharedInstance('fightSmsTransport');
        }

        if (ENVIRONMENT === 'production') {
            return new \Fight\Common\Adapter\Sms\Twilio\TwilioSmsTransport(static::fightTwilioClient());
        }

        return new \Fight\Common\Adapter\Sms\Null\NullSmsTransport();
    }

    /**
     * Creates the credential-qualified SMS provider client
     */
    public static function fightTwilioClient(bool $getShared = true): \Twilio\Rest\Client
    {
        if ($getShared) {
            return static::getSharedInstance('fightTwilioClient');
        }
        $config = config('FightCommon');

        return new \Twilio\Rest\Client(
            $config->twilioAccountSidForEnvironment(),
            $config->twilioAuthTokenForEnvironment()
        );
    }

    /**
     * Creates the production hub or safe local mock hub
     */
    public static function fightMercureHub(bool $getShared = true): HubInterface
    {
        if ($getShared) {
            return static::getSharedInstance('fightMercureHub');
        }
        $config = config('FightCommon');
        $url = $config->mercureUrlForEnvironment();
        $tokenProvider = new \Symfony\Component\Mercure\Jwt\StaticTokenProvider($config->mercureJwtForEnvironment());

        if (ENVIRONMENT === 'production') {
            return new \Symfony\Component\Mercure\Hub($url, $tokenProvider);
        }

        return new \Symfony\Component\Mercure\MockHub(
            $url,
            $tokenProvider,
            static fn (): string => 'local-profile'
        );
    }

    /**
     * Creates public publication over the registered hub
     */
    public static function fightPublisher(bool $getShared = true): Publisher
    {
        if ($getShared) {
            return static::getSharedInstance('fightPublisher');
        }

        return new \Fight\Common\Adapter\Socket\MercureHubPublisher(service('fightMercureHub'));
    }

    /**
     * Creates private publication over the registered hub
     */
    public static function fightPrivatePublisher(bool $getShared = true): PrivatePublisher
    {
        if ($getShared) {
            return static::getSharedInstance('fightPrivatePublisher');
        }

        return new \Fight\Common\Adapter\Socket\PrivateMercureHubPublisher(service('fightMercureHub'));
    }

    /**
     * Creates the shared command router for project handler registrations
     */
    public static function fightCommandRouter(bool $getShared = true): InMemoryCommandRouter
    {
        if ($getShared) {
            return static::getSharedInstance('fightCommandRouter');
        }

        return new InMemoryCommandRouter();
    }

    /**
     * Creates the shared HTTP provider client
     */
    public static function fightGuzzleClient(bool $getShared = true): \GuzzleHttp\ClientInterface
    {
        if ($getShared) {
            return static::getSharedInstance('fightGuzzleClient');
        }

        return new \GuzzleHttp\Client();
    }

    /**
     * Creates the shared template environment
     */
    public static function fightTwigEnvironment(bool $getShared = true): Environment
    {
        if ($getShared) {
            return static::getSharedInstance('fightTwigEnvironment');
        }

        return new Environment(new ArrayLoader(['receipt.twig' => 'Fight {{ framework }} receipt']));
    }

    /**
     * Creates the shared local storage provider
     */
    public static function fightFlysystem(bool $getShared = true): \League\Flysystem\FilesystemOperator
    {
        if ($getShared) {
            return static::getSharedInstance('fightFlysystem');
        }

        return new \League\Flysystem\Filesystem(
            new \League\Flysystem\Local\LocalFilesystemAdapter(config('FightCommon')->storagePath)
        );
    }
}
