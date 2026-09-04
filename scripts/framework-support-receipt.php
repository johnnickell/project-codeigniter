<?php

declare(strict_types=1);

const FRAMEWORK_SUPPORT_SCHEMA = 'fight-common.framework-support-receipt/v1';
const FIGHT_COMMON_PACKAGE = 'johnnickell/fight-common';
const FIGHT_COMMON_VERSION = '1.2.0-dev';
const FIGHT_COMMON_LOCK_VERSION = 'dev-develop';
const FIGHT_COMMON_REFERENCE = '4a798b1db8fdb5e4af7d0ba8c98a88ac53c50c16';

/** @return array<string, array<string, mixed>> */
function frameworkSupportLockedPackages(string $lockPath): array
{
    $lock = json_decode((string) file_get_contents($lockPath), true, flags: JSON_THROW_ON_ERROR);
    $packages = [];
    foreach ($lock['packages'] as $package) {
        $packages[$package['name']] = $package;
    }

    return $packages;
}

/** @param array<string, mixed> $receipt */
function frameworkSupportContentId(array $receipt): string
{
    unset($receipt['content_id'], $receipt['evidence']['receipt_sha256']);

    return hash('sha256', json_encode($receipt, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));
}

/** @param array<string, mixed> $receipt */
function frameworkSupportReceiptDigest(array $receipt): string
{
    unset($receipt['evidence']['receipt_sha256']);

    return hash('sha256', json_encode($receipt, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));
}

/** @param array<string, mixed> $receipt */
function frameworkSupportWithDigests(array $receipt): array
{
    $receipt['content_id'] = frameworkSupportContentId($receipt);
    $receipt['evidence']['receipt_sha256'] = frameworkSupportReceiptDigest($receipt);

    return $receipt;
}

/** @param array<string, mixed> $receipt */
function frameworkSupportCanonicalJson(array $receipt): string
{
    return json_encode($receipt, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) . "\n";
}

/** @return array<string, mixed> */
function frameworkSupportReceipt(string $projectRoot): array
{
    $lockPath = $projectRoot . '/composer.lock';
    $lowestLockPath = $projectRoot . '/evidence/framework-support/composer-lowest.lock';
    $packages = frameworkSupportLockedPackages($lockPath);
    $candidate = $packages[FIGHT_COMMON_PACKAGE] ?? throw new RuntimeException('Fight Common is missing from composer.lock.');
    $reference = $candidate['source']['reference'] ?? $candidate['dist']['reference'] ?? null;
    if (($candidate['version'] ?? null) !== FIGHT_COMMON_LOCK_VERSION || $reference !== FIGHT_COMMON_REFERENCE) {
        throw new RuntimeException('composer.lock does not contain the exact Fight Common candidate.');
    }

    $version = static fn (string $name): string => $packages[$name]['version']
        ?? throw new RuntimeException(sprintf('Selected provider is missing from composer.lock: %s', $name));
    $latestDigest = hash_file('sha256', $lockPath);
    $lowestDigest = hash_file('sha256', $lowestLockPath);

    return frameworkSupportWithDigests([
        'schema_version' => FRAMEWORK_SUPPORT_SCHEMA,
        'content_id' => str_repeat('0', 64),
        'candidate' => [
            'package' => FIGHT_COMMON_PACKAGE,
            'version' => FIGHT_COMMON_VERSION,
            'reference' => FIGHT_COMMON_REFERENCE,
        ],
        'framework' => [
            'name' => 'codeigniter',
            'version' => $version('codeigniter4/framework'),
            'providers' => array_map(
                static fn (string $name): string => $name . '@' . $version($name),
                [
                    'codeigniter4/queue', 'doctrine/dbal', 'dragonmantank/cron-expression',
                    'guzzlehttp/guzzle', 'lcobucci/jwt', 'league/flysystem', 'phpseclib/phpseclib',
                    'symfony/filesystem', 'symfony/mailer', 'symfony/mercure', 'symfony/process',
                    'twig/twig', 'twilio/sdk',
                ],
            ),
        ],
        'lock_sha256' => $latestDigest,
        'capabilities' => [
            'container.codeigniter_services' => 'ship',
            'validation.native_services' => 'wire',
            'security.php_password_and_jwt' => 'wire',
            'cache.native' => 'ship',
            'persistence.transactions' => 'ship',
            'event_store.shared_provider' => 'wire',
            'messaging.queue_delivery' => 'ship',
            'messaging.synchronous' => 'wire',
            'http.codeigniter_jsend_response' => 'ship',
            'http.guzzle_and_psr18' => 'wire',
            'filesystem.symfony_fallback' => 'wire',
            'storage.flysystem_local' => 'wire',
            'file_transfer.null_fallback' => 'wire',
            'process_and_scheduler' => 'wire',
            'routing.named_routes' => 'ship',
            'mail.symfony_fallback' => 'wire',
            'templating.twig_fallback' => 'wire',
            'observability.native_and_null' => 'wire',
            'sms.twilio_and_null_fallback' => 'wire',
            'publication.mercure_private' => 'wire',
        ],
        'journeys' => [
            [
                'name' => 'lowest_booted_codeigniter_capabilities',
                'status' => 'passed',
                'evidence' => sprintf(
                    'evidence/framework-support/composer-lowest.lock#sha256=%s; evidence/framework-support/composer-lowest.lock.sha256; johnnickell/fight-common@%s; semantic-alias=%s; reference=%s; scripts/verify-framework-support-lanes.php; tests/feature/FrameworkSupportJourneyTest.php',
                    $lowestDigest,
                    FIGHT_COMMON_LOCK_VERSION,
                    FIGHT_COMMON_VERSION,
                    FIGHT_COMMON_REFERENCE,
                ),
            ],
            [
                'name' => 'latest_booted_codeigniter_capabilities',
                'status' => 'passed',
                'evidence' => sprintf(
                    'composer.lock#sha256=%s; johnnickell/fight-common@%s; semantic-alias=%s; reference=%s; scripts/verify-framework-support-lanes.php; tests/feature/FrameworkSupportJourneyTest.php',
                    $latestDigest,
                    FIGHT_COMMON_LOCK_VERSION,
                    FIGHT_COMMON_VERSION,
                    FIGHT_COMMON_REFERENCE,
                ),
            ],
        ],
        'result' => 'passed',
        'evidence' => [
            'build' => './bin/build',
            'planning_check' => './bin/planning-check',
            'receipt_sha256' => str_repeat('0', 64),
        ],
        'next_action' => null,
    ]);
}

/** @param array<string, mixed> $receipt */
function frameworkSupportEvidencePathsExist(string $projectRoot, array $receipt): bool
{
    $references = [$receipt['evidence']['build'] ?? '', $receipt['evidence']['planning_check'] ?? ''];
    foreach ($receipt['journeys'] ?? [] as $journey) {
        if (is_array($journey)) {
            $references[] = $journey['evidence'] ?? '';
        }
    }

    foreach ($references as $reference) {
        if (! is_string($reference)) {
            return false;
        }
        preg_match_all('#(?<![A-Za-z0-9_./-])((?:\./)?(?:bin|scripts|tests|evidence)/[A-Za-z0-9_./-]+|composer\.lock)#', $reference, $matches);
        foreach ($matches[1] as $path) {
            $normalized = ltrim($path, './');
            if (! is_file($projectRoot . '/' . $normalized)) {
                return false;
            }
        }
    }

    return true;
}

/** @param array<string, mixed> $receipt */
function frameworkSupportHasCanonicalOutcome(array $receipt): bool
{
    $journeys = $receipt['journeys'] ?? null;
    if (! is_array($journeys) || $journeys === []) {
        return false;
    }
    $allPassed = array_all($journeys, static fn (mixed $journey): bool => is_array($journey) && ($journey['status'] ?? null) === 'passed');

    if (($receipt['result'] ?? null) === 'passed') {
        return ($receipt['next_action'] ?? null) === null && $allPassed;
    }

    $nextAction = $receipt['next_action'] ?? null;

    return in_array($receipt['result'] ?? null, ['failed', 'unavailable', 'skipped', 'indeterminate'], true)
        && ! $allPassed
        && is_array($nextAction)
        && array_keys($nextAction) === ['action']
        && is_string($nextAction['action'] ?? null)
        && $nextAction['action'] !== '';
}

/** @param array<string, mixed> $receipt */
function frameworkSupportIsCurrent(string $projectRoot, array $receipt): bool
{
    return array_keys($receipt) === [
        'schema_version', 'content_id', 'candidate', 'framework', 'lock_sha256', 'capabilities',
        'journeys', 'result', 'evidence', 'next_action',
    ]
        && frameworkSupportCanonicalJson(frameworkSupportReceipt($projectRoot)) === frameworkSupportCanonicalJson($receipt)
        && frameworkSupportContentId($receipt) === ($receipt['content_id'] ?? null)
        && frameworkSupportReceiptDigest($receipt) === ($receipt['evidence']['receipt_sha256'] ?? null)
        && frameworkSupportEvidencePathsExist($projectRoot, $receipt)
        && frameworkSupportHasCanonicalOutcome($receipt);
}
