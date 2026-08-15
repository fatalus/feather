<?php

$engine = new Feather\Engine();

return [
  'GET' => [
    '/' => fn() => $engine->render('home'),
    '/hello' => fn() => 'Hello, world!',
  ]
];
