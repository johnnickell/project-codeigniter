<?php

declare(strict_types=1);

use CodeIgniter\Test\CIUnitTestCase;

/** @internal */
final class ProductionProfileVerificationTest extends CIUnitTestCase
{
    public function test_production_profile_rejects_missing_provider_configuration(): void
    {
        [$status, $output] = $this->runVerifier([]);

        $this->assertSame(1, $status);
        $this->assertSame(
            "Production profile correctly rejected unsafe configuration: FightCommon production configuration requires jwtSecret.\n",
            $output,
        );
    }

    public function test_production_profile_boots_with_explicit_safe_provider_configuration(): void
    {
        [$status, $output] = $this->runVerifier([
            'fightcommon_jwtSecret' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'fightcommon_mercureUrl' => 'https://mercure.example.test/.well-known/mercure',
            'fightcommon_mercureJwt' => 'header.payload.signature',
            'fightcommon_twilioAccountSid' => 'AC00000000000000000000000000000000',
            'fightcommon_twilioAuthToken' => 'test-auth-token',
        ]);

        $this->assertSame(0, $status);
        $this->assertSame("Production Fight Common profile booted and exercised with explicit safe configuration.\n", $output);
    }

    public function test_declared_php_floor_matches_the_locked_common_candidate(): void
    {
        exec(escapeshellarg(PHP_BINARY) . ' scripts/verify-composer-runtime-policy.php 2>&1', $lines, $status);

        $this->assertSame(0, $status);
        $this->assertSame("Composer runtime policy passed.\n", implode("\n", $lines) . "\n");
    }

    /** @param array<string, string> $configuration @return array{int, string} */
    private function runVerifier(array $configuration): array
    {
        $environment = ['CI_ENVIRONMENT=production'];
        foreach ($configuration as $name => $value) {
            $environment[] = $name . '=' . escapeshellarg($value);
        }

        $command = implode(' ', $environment) . ' ' . escapeshellarg(PHP_BINARY) . ' scripts/verify-production-framework-support-profile.php 2>&1';
        exec($command, $lines, $status);

        return [$status, implode("\n", $lines) . ($lines === [] ? '' : "\n")];
    }
}
