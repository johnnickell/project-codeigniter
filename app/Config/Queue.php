<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Queue\Config\Queue as BaseQueue;
use Fight\Common\Adapter\Messaging\CodeIgniter\CommandMessageJob;
use Fight\Common\Adapter\Messaging\CodeIgniter\EventMessageJob;

final class Queue extends BaseQueue
{
    public array $jobHandlers = [
        'fight-command' => CommandMessageJob::class,
        'fight-event'   => EventMessageJob::class,
    ];
}
