<?php

namespace Config;

use App\Services\StarterGreeting;
use CodeIgniter\Config\BaseService;
use Fight\Common\Adapter\Cache\CodeIgniter\CodeIgniterCache;
use Fight\Common\Adapter\Messaging\CodeIgniter\QueueCommandBus;
use Fight\Common\Adapter\Messaging\CodeIgniter\QueueEventDispatcher;
use Fight\Common\Adapter\Persistence\CodeIgniter\CodeIgniterTransactionalUnitOfWork;
use Fight\Common\Adapter\Routing\CodeIgniter\CodeIgniterUrlGenerator;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\CacheServices;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\FilesystemServices;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\MailServices;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\MessagingServices;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\PersistenceServices;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\RoutingServices;
use Fight\Common\Adapter\ServiceContainer\CodeIgniter\TemplateServices;
use Fight\Common\Application\Filesystem\Filesystem;
use Fight\Common\Application\Mail\Message\MailFactory;
use Fight\Common\Application\Mail\Transport\MailTransport;
use Fight\Common\Application\Templating\TemplateEngine;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\NullTransport;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    public static function starterGreeting(bool $getShared = true): StarterGreeting
    {
        if ($getShared) {
            return static::getSharedInstance('starterGreeting');
        }

        return new StarterGreeting();
    }

    public static function fightCommandBus(bool $getShared = true): QueueCommandBus
    {
        if ($getShared) {
            return static::getSharedInstance('fightCommandBus');
        }

        return MessagingServices::queueCommandBus(service('queue'), 'fight', 'fight-command');
    }

    public static function fightEventDispatcher(bool $getShared = true): QueueEventDispatcher
    {
        if ($getShared) {
            return static::getSharedInstance('fightEventDispatcher');
        }

        return MessagingServices::queueEventDispatcher(service('queue'), 'fight', 'fight-event');
    }

    public static function fightCommandMessageHandler(bool $getShared = true): \Fight\Common\Adapter\Messaging\Handler\CommandMessageHandler
    {
        if ($getShared) return static::getSharedInstance('fightCommandMessageHandler');
        return MessagingServices::commandMessageHandler(static::fightSynchronousCommandBus());
    }

    public static function fightEventMessageHandler(bool $getShared = true): \Fight\Common\Adapter\Messaging\Handler\EventMessageHandler
    {
        if ($getShared) return static::getSharedInstance('fightEventMessageHandler');
        return MessagingServices::eventMessageHandler(static::fightSynchronousEventDispatcher());
    }

    public static function fightValidation(bool $getShared = true): \CodeIgniter\Validation\ValidationInterface
    {
        if ($getShared) return static::getSharedInstance('fightValidation');
        return service('validation');
    }

    public static function fightRequest(bool $getShared = true): \CodeIgniter\HTTP\RequestInterface
    {
        if ($getShared) return static::getSharedInstance('fightRequest');
        return service('request');
    }

    public static function fightResponse(bool $getShared = true): \CodeIgniter\HTTP\ResponseInterface
    {
        if ($getShared) return static::getSharedInstance('fightResponse');
        return service('response');
    }

    public static function fightTransactionalUnitOfWork(bool $getShared = true): CodeIgniterTransactionalUnitOfWork
    {
        if ($getShared) {
            return static::getSharedInstance('fightTransactionalUnitOfWork');
        }

        return PersistenceServices::codeIgniterTransactionalUnitOfWork(db_connect());
    }

    public static function fightCache(bool $getShared = true): CodeIgniterCache
    {
        if ($getShared) {
            return static::getSharedInstance('fightCache');
        }

        return CacheServices::cache(cache());
    }

    public static function fightUrlGenerator(bool $getShared = true): CodeIgniterUrlGenerator
    {
        if ($getShared) {
            return static::getSharedInstance('fightUrlGenerator');
        }

        return RoutingServices::urlGenerator(service('routes'), config('App')->baseURL);
    }

    public static function fightMailFactory(bool $getShared = true): MailFactory
    {
        if ($getShared) {
            return static::getSharedInstance('fightMailFactory');
        }

        return MailServices::mailFactory();
    }

    public static function fightMailer(bool $getShared = true): MailerInterface
    {
        if ($getShared) {
            return static::getSharedInstance('fightMailer');
        }

        return new Mailer(new NullTransport());
    }

    public static function fightMailTransport(bool $getShared = true): MailTransport
    {
        if ($getShared) {
            return static::getSharedInstance('fightMailTransport');
        }

        return MailServices::mailTransport(static::fightMailer());
    }

    public static function fightTemplateEngine(bool $getShared = true): TemplateEngine
    {
        if ($getShared) {
            return static::getSharedInstance('fightTemplateEngine');
        }

        return TemplateServices::templateEngine(new Environment(new ArrayLoader([
            'receipt.twig' => 'Fight {{ framework }} receipt',
        ])));
    }

    public static function fightFilesystem(bool $getShared = true): Filesystem
    {
        if ($getShared) {
            return static::getSharedInstance('fightFilesystem');
        }

        return FilesystemServices::filesystem();
    }

    public static function fightPasswordHasher(bool $getShared = true): \Fight\Common\Application\Auth\Security\PasswordHasher
    {
        if ($getShared) return static::getSharedInstance('fightPasswordHasher');
        return new \Fight\Common\Adapter\Auth\Security\PhpPasswordHasher(PASSWORD_DEFAULT);
    }

    public static function fightPasswordValidator(bool $getShared = true): \Fight\Common\Application\Auth\Security\PasswordValidator
    {
        if ($getShared) return static::getSharedInstance('fightPasswordValidator');
        return new \Fight\Common\Adapter\Auth\Security\PhpPasswordValidator(PASSWORD_DEFAULT);
    }

    public static function fightJwtEncoder(bool $getShared = true): \Fight\Common\Adapter\Auth\Security\JwtEncoder
    {
        if ($getShared) return static::getSharedInstance('fightJwtEncoder');
        return new \Fight\Common\Adapter\Auth\Security\JwtEncoder(config('FightCommon')->jwtSecretForEnvironment());
    }

    public static function fightJwtDecoder(bool $getShared = true): \Fight\Common\Adapter\Auth\Security\JwtDecoder
    {
        if ($getShared) return static::getSharedInstance('fightJwtDecoder');
        return new \Fight\Common\Adapter\Auth\Security\JwtDecoder(config('FightCommon')->jwtSecretForEnvironment());
    }

    public static function fightEventMapper(bool $getShared = true): \Fight\Common\Domain\EventSourcing\EventMapper
    {
        if ($getShared) return static::getSharedInstance('fightEventMapper');
        return new \Fight\Common\Domain\EventSourcing\EventMapper([]);
    }

    public static function fightEventStore(bool $getShared = true): \Fight\Common\Domain\EventSourcing\EventStore
    {
        if ($getShared) return static::getSharedInstance('fightEventStore');
        return new \Fight\Common\Adapter\EventSourcing\InMemory\InMemoryEventStore(static::fightEventMapper());
    }

    public static function fightSynchronousCommandBus(bool $getShared = true): \Fight\Common\Application\Messaging\Command\SynchronousCommandBus
    {
        if ($getShared) return static::getSharedInstance('fightSynchronousCommandBus');
        return new \Fight\Common\Adapter\Messaging\Command\Sync\RoutingCommandBus(new \Fight\Common\Adapter\Messaging\Command\Sync\Routing\InMemoryCommandRouter());
    }

    public static function fightSynchronousEventDispatcher(bool $getShared = true): \Fight\Common\Application\Messaging\Event\SynchronousEventDispatcher
    {
        if ($getShared) return static::getSharedInstance('fightSynchronousEventDispatcher');
        return new \Fight\Common\Adapter\Messaging\Event\Sync\SimpleEventDispatcher();
    }

    public static function fightHttpClient(bool $getShared = true): \Fight\Common\Application\HttpClient\Transport\HttpClient
    {
        if ($getShared) return static::getSharedInstance('fightHttpClient');
        return new \Fight\Common\Adapter\HttpClient\Guzzle\GuzzleClient(new \GuzzleHttp\Client());
    }

    public static function fightPsr18Client(bool $getShared = true): \Psr\Http\Client\ClientInterface
    {
        if ($getShared) return static::getSharedInstance('fightPsr18Client');
        return new \Fight\Common\Adapter\HttpClient\Psr18\Psr18Client(service('fightHttpClient'));
    }

    public static function fightMessageFactory(bool $getShared = true): \Fight\Common\Application\HttpClient\Message\MessageFactory
    {
        if ($getShared) return static::getSharedInstance('fightMessageFactory');
        return new \Fight\Common\Adapter\HttpClient\Guzzle\GuzzleMessageFactory();
    }

    public static function fightUriFactory(bool $getShared = true): \Fight\Common\Application\HttpClient\Message\UriFactory
    {
        if ($getShared) return static::getSharedInstance('fightUriFactory');
        return new \Fight\Common\Adapter\HttpClient\Guzzle\GuzzleUriFactory();
    }

    public static function fightFileStorage(bool $getShared = true): \Fight\Common\Application\FileStorage\FileStorage
    {
        if ($getShared) return static::getSharedInstance('fightFileStorage');
        $filesystem = new \League\Flysystem\Filesystem(new \League\Flysystem\Local\LocalFilesystemAdapter(config('FightCommon')->storagePath));
        return new \Fight\Common\Adapter\FileStorage\FlysystemStorage($filesystem);
    }

    public static function fightFileTransfer(bool $getShared = true): \Fight\Common\Application\FileTransfer\Transport\FileTransport
    {
        if ($getShared) return static::getSharedInstance('fightFileTransfer');
        return new \Fight\Common\Adapter\FileTransfer\Null\NullFileTransport();
    }

    public static function fightProcessRunner(bool $getShared = true): \Fight\Common\Application\Process\ProcessRunner
    {
        if ($getShared) return static::getSharedInstance('fightProcessRunner');
        return new \Fight\Common\Adapter\Process\Symfony\SymfonyProcessRunner(service('logger'));
    }

    public static function fightScheduler(bool $getShared = true): \Fight\Common\Application\Scheduler\Scheduler
    {
        if ($getShared) return static::getSharedInstance('fightScheduler');
        return \Fight\Common\Application\Scheduler\Scheduler::withProcessRunner(new \Fight\Common\Domain\Value\DateTime\Timezone(config('FightCommon')->timezone), WRITEPATH, static::fightProcessRunner(), service('logger'));
    }

    public static function fightAuditLog(bool $getShared = true): \Fight\Common\Application\Observability\AuditLog
    {
        if ($getShared) return static::getSharedInstance('fightAuditLog');
        return new \Fight\Common\Adapter\Observability\Audit\LoggingAuditLog(service('logger'));
    }

    public static function fightMetrics(bool $getShared = true): \Fight\Common\Application\Observability\MetricsCollector
    {
        if ($getShared) return static::getSharedInstance('fightMetrics');
        return new \Fight\Common\Adapter\Observability\Metrics\NullMetricsCollector();
    }

    public static function fightHealthReporter(bool $getShared = true): \Fight\Common\Application\Observability\HealthAggregator
    {
        if ($getShared) return static::getSharedInstance('fightHealthReporter');
        return new \Fight\Common\Adapter\Observability\Health\HealthReporter();
    }

    public static function fightSmsTransport(bool $getShared = true): \Fight\Common\Application\Sms\Transport\SmsTransport
    {
        if ($getShared) return static::getSharedInstance('fightSmsTransport');
        return new \Fight\Common\Adapter\Sms\Null\NullSmsTransport();
    }

    public static function fightTwilioClient(bool $getShared = true): \Twilio\Rest\Client
    {
        if ($getShared) return static::getSharedInstance('fightTwilioClient');
        $config = config('FightCommon');
        return new \Twilio\Rest\Client($config->twilioAccountSidForEnvironment(), $config->twilioAuthTokenForEnvironment());
    }

    public static function fightMercureHub(bool $getShared = true): \Symfony\Component\Mercure\HubInterface
    {
        if ($getShared) return static::getSharedInstance('fightMercureHub');
        $config = config('FightCommon');
        $url = $config->mercureUrlForEnvironment();
        $tokenProvider = new \Symfony\Component\Mercure\Jwt\StaticTokenProvider($config->mercureJwtForEnvironment());

        if (ENVIRONMENT === 'production') {
            return new \Symfony\Component\Mercure\Hub($url, $tokenProvider);
        }

        return new \Symfony\Component\Mercure\MockHub(
            $url,
            $tokenProvider,
            static fn (): string => 'local-profile',
        );
    }

    public static function fightPublisher(bool $getShared = true): \Fight\Common\Application\Socket\Publisher
    {
        if ($getShared) return static::getSharedInstance('fightPublisher');
        return new \Fight\Common\Adapter\Socket\MercureHubPublisher(service('fightMercureHub'));
    }

    public static function fightPrivatePublisher(bool $getShared = true): \Fight\Common\Application\Socket\PrivatePublisher
    {
        if ($getShared) return static::getSharedInstance('fightPrivatePublisher');
        return new \Fight\Common\Adapter\Socket\PrivateMercureHubPublisher(service('fightMercureHub'));
    }

    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */
}
