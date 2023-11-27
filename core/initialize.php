<?php

define('ROOT', dirname(__DIR__));

$composer = ROOT . '/vendor/autoload.php';
if(file_exists($composer)) require $composer;

const CORE = __DIR__;

require CORE . '/version.php';

require CORE . '/config.php';

require CORE . '/extensions/e_configdir__/index.php';

define('CACHE', _env('CACHE_ROOT_PATH', CORE . '/cache'));

require CORE . '/ini.config.php';

require CORE . '/app/console/console.php';

require CORE . '/app/app.php';