<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

foreach (glob(__DIR__ . '/cache/*') as $file) {
    if (is_file($file) && is_readable($file)) {
        unlink($file);
    }
}
