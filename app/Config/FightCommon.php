<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Config\BaseConfig;

final class FightCommon extends BaseConfig
{
    /**
     * Production credentials are deliberately empty until application
     * configuration supplies them through CodeIgniter environment overrides.
     */
    public string $jwtSecret = '';
    public string $mercureUrl = '';
    public string $mercureJwt = '';
    public string $storagePath = WRITEPATH . 'fight-common-storage';
    public string $timezone = 'UTC';
    public string $twilioAccountSid = '';
    public string $twilioAuthToken = '';

    public function jwtSecretForEnvironment(): string
    {
        return $this->configuredValue('jwtSecret', str_repeat('a', 64));
    }

    public function mercureUrlForEnvironment(): string
    {
        return $this->configuredValue('mercureUrl', 'http://localhost/.well-known/mercure');
    }

    public function mercureJwtForEnvironment(): string
    {
        return $this->configuredValue('mercureJwt', 'local-profile-token');
    }

    public function twilioAccountSidForEnvironment(): string
    {
        return $this->configuredValue('twilioAccountSid', 'AC' . str_repeat('0', 32));
    }

    public function twilioAuthTokenForEnvironment(): string
    {
        return $this->configuredValue('twilioAuthToken', 'local-profile-token');
    }

    private function configuredValue(string $property, string $localDefault): string
    {
        $value = trim($this->{$property});
        if ($value !== '') {
            return $value;
        }

        if (ENVIRONMENT !== 'production') {
            return $localDefault;
        }

        throw new \RuntimeException("FightCommon production configuration requires {$property}.");
    }
}
