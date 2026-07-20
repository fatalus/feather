<?php

declare(strict_type = 1);

namespace Feather\Exceptions;

use Exception;

class FeatherException extends Exception {
    public function __construct() {
        parent::__construct();
    }
}