<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Config\BaseConfig;

final class FightCommon extends BaseConfig
{
    public string $jwtSecret = '0000000000000000000000000000000000000000000000000000000000000000';
    public string $storagePath = WRITEPATH . 'fight-common-storage';
    public string $timezone = 'UTC';
    public string $twilioAccountSid = '';
    public string $twilioAuthToken = '';
}
