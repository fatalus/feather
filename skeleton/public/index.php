<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Feather\Kernel;

define('FEATHER_ROOT', realpath(rtrim(__DIR__ . '/..', DIRECTORY_SEPARATOR)));

$kernel = new Kernel();

echo $kernel->handle();