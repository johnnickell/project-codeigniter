<?php

declare(strict_types=1);

// Static-analysis constants only; never boot HTTP, connect a database or resolve services.
$root = dirname(__DIR__).'/';
define('ROOTPATH', $root);
define('HOMEPATH', $root);
define('APPPATH', $root.'app/');
define('SYSTEMPATH', $root.'vendor/codeigniter4/framework/system/');
define('WRITEPATH', $root.'writable/');
define('TESTPATH', $root.'tests/');
define('FCPATH', $root.'public/');
define('ENVIRONMENT', 'testing');
define('CI_DEBUG', true);
