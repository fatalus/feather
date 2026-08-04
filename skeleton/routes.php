<?php

$engine = new Feather\Engine();

return [
  '/' => fn() => $engine->render('home'),
  '/hello' => fn() => 'Hello, world!',
];
