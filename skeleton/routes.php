<?php

use Feather\Engine;

return [
  '/' => fn() => Engine::render('home'),
  '/hello' => fn() => 'Hello, world!',
];
