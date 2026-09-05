<?php

declare(strict_types=1);

use CodeIgniter\Test\CIUnitTestCase;

require_once __DIR__ . '/../../scripts/framework-support-receipt.php';

/** @internal */
final class FrameworkSupportReceiptTest extends CIUnitTestCase
{
    public function test_framework_support_manifest_requires_the_non_overlapping_flysystem_generation(): void
    {
        $manifest = json_decode((string) file_get_contents(dirname(__DIR__, 2) . '/composer.json'), true, flags: JSON_THROW_ON_ERROR);

        $this->assertSame('^3.36', $manifest['require']['league/flysystem'] ?? null);
        $this->assertSame('^3.35', $manifest['require']['league/flysystem-local'] ?? null);
    }

    public function test_dependency_lane_verifier_rejects_an_ambiguous_class_resolution_warning(): void
    {
        $root = dirname(__DIR__, 2);
        $bin = sys_get_temp_dir() . '/project-codeigniter-fake-composer-' . bin2hex(random_bytes(6));
        mkdir($bin, 0700);
        $composer = $bin . '/composer';

        file_put_contents($composer, <<<'SH'
#!/bin/sh
set -eu

echo 'Warning: Ambiguous class resolution, "League\\Flysystem\\Local\\LocalFilesystemAdapter" was found.' >&2

case " $* " in
  *" --prefer-lowest "*) cp "$PROJECT_CODEIGNITER_LOWEST_LOCK" composer.lock ;;
esac

case " $* " in
  *" install "*)
    mkdir -p vendor/bin
    printf '%s\n' '<?php exit(0);' > vendor/bin/phpunit
    ;;
esac
SH
        );
        chmod($composer, 0700);

        try {
            $command = sprintf(
                'PATH=%s PROJECT_CODEIGNITER_LOWEST_LOCK=%s %s scripts/verify-framework-support-lanes.php 2>&1',
                escapeshellarg($bin . ':' . dirname(PHP_BINARY) . ':/usr/bin:/bin'),
                escapeshellarg($root . '/evidence/framework-support/composer-lowest.lock'),
                escapeshellarg(PHP_BINARY),
            );
            exec($command, $lines, $status);

            $this->assertNotSame(0, $status);
            $this->assertStringContainsString('Ambiguous class resolution', implode("\n", $lines));
        } finally {
            @unlink($composer);
            @rmdir($bin);
        }
    }

    public function test_the_committed_receipt_is_canonical_and_records_the_exact_candidate_and_both_locks(): void
    {
        $root = dirname(__DIR__, 2);
        $path = $root . '/evidence/framework-support/receipt-v1.json';
        $receipt = json_decode((string) file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);

        $this->assertSame([
            'schema_version', 'content_id', 'candidate', 'framework', 'lock_sha256', 'capabilities',
            'journeys', 'result', 'evidence', 'next_action',
        ], array_keys($receipt));
        $this->assertSame(FRAMEWORK_SUPPORT_SCHEMA, $receipt['schema_version']);
        $this->assertSame([
            'package' => 'johnnickell/fight-common',
            'version' => '1.2.0-dev',
            'reference' => FIGHT_COMMON_REFERENCE,
        ], $receipt['candidate']);
        $this->assertSame('codeigniter', $receipt['framework']['name']);
        $this->assertSame(hash_file('sha256', $root . '/composer.lock'), $receipt['lock_sha256']);
        $this->assertSame(frameworkSupportCanonicalJson($receipt), (string) file_get_contents($path));
        $this->assertSame(frameworkSupportCanonicalJson(frameworkSupportReceipt($root)), (string) file_get_contents($path));
        $this->assertSame(frameworkSupportContentId($receipt), $receipt['content_id']);
        $this->assertSame(frameworkSupportReceiptDigest($receipt), $receipt['evidence']['receipt_sha256']);
        $this->assertTrue(frameworkSupportEvidencePathsExist($root, $receipt));
        $this->assertStringContainsString(
            hash_file('sha256', $root . '/evidence/framework-support/composer-lowest.lock'),
            $receipt['journeys'][0]['evidence'],
        );
        foreach ($receipt['journeys'] as $journey) {
            $this->assertStringContainsString('johnnickell/fight-common@dev-develop', $journey['evidence']);
            $this->assertStringContainsString('semantic-alias=1.2.0-dev', $journey['evidence']);
            $this->assertStringContainsString(FIGHT_COMMON_REFERENCE, $journey['evidence']);
        }

        foreach ($receipt['capabilities'] as $state) {
            $this->assertContains($state, ['ship', 'wire', 'unavailable']);
        }
        foreach ($receipt['journeys'] as $journey) {
            $this->assertSame(['name', 'status', 'evidence'], array_keys($journey));
            $this->assertContains($journey['status'], ['passed', 'failed', 'unavailable', 'skipped', 'indeterminate']);
        }
        $this->assertTrue(frameworkSupportHasCanonicalOutcome($receipt));
    }

    public function test_the_exact_candidate_authority_validates_the_committed_receipt(): void
    {
        $root = dirname(__DIR__, 2);
        $authorityPath = $root . '/vendor/johnnickell/fight-common/release/src/Application/StarterSupportReceiptAuthority.php';
        $this->assertFileExists($authorityPath);
        require_once $authorityPath;

        $receipt = json_decode((string) file_get_contents($root . '/evidence/framework-support/receipt-v1.json'), true, flags: JSON_THROW_ON_ERROR);
        $this->assertTrue((new \Fight\Release\Application\StarterSupportReceiptAuthority())->isValid($receipt));
    }

    public function test_non_passing_receipts_require_exactly_one_resumable_action(): void
    {
        $receipt = [
            'result' => 'failed',
            'journeys' => [['name' => 'failed journey', 'status' => 'failed', 'evidence' => 'tests/feature/FrameworkSupportJourneyTest.php']],
            'next_action' => ['action' => 'Repair the failed journey.'],
        ];

        $this->assertTrue(frameworkSupportHasCanonicalOutcome($receipt));
        $receipt['next_action']['owner'] = 'starter';
        $this->assertFalse(frameworkSupportHasCanonicalOutcome($receipt));
    }
}
