<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/tests',
        __DIR__.'/scripts',
        __DIR__.'/public/index.php',
        __DIR__.'/spark',
        __DIR__.'/preload.php',
        __FILE__
    ])
    ->withCache(__DIR__.'/.runs/cache/rector')
    ->withRules([SimplifyIfReturnBoolRector::class]);
