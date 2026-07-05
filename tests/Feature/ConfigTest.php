<?php

use FileHelper;

test('if config file can be found', function () {
    $fp = FileHelper::getConfigFile('development.php');
    expect($fp)->toBeString()->not()->toBe('');
});
