# Feather

A modular, minimalist PHP microframework.

This project was a result of me attempting to write a PHP application from scratch, which somehow turned into a tiny microframework. You can read more of the whereabouts and the origin of this on my [Website](https://fatalus.dev/source)

> **Note**
> Feather is in early development and is **not available on Packagist** (yet).

## Getting Started

Install Feather as a Composer dependency.

```bash
composer require fatalus/feather
```

Create a `public/index.php` file:
Or copy the code from `skeleton/` into your projects root and you're good to go!

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Feather\Kernel;

define('FEATHER_ROOT', rtrim(__DIR__ . '/..', DIRECTORY_SEPARATOR));

$kernel = new Kernel();

echo $kernel->handle();
```

If the entry point to your Web-Server is not located at `public/index.php`, remember to adjust the `FEATHER_ROOT` constant accordingly so it points to the project root.

## Routing

Create a `routes.php` file in the project root.

```php
<?php

use MyApp\PostController;
use Feather\Engine;

return [
  '/' => fn() => Engine::render('home'),
  '/hello' => fn() => 'Hello, world!',
  '/posts/(?<slug>[a-zA-Z0-9-]+)' => fn(array $params) => PostController::show($params['slug']),
];

use Forza\;

$engine = new Feather\Engine();
$auth = new MyApp\Controller\AuthController();
$post = new MyApp\Controller\PostController();

return [
  'GET' => [
    '/' => fn() => $engine->render('home'),
    '/hello' => fn() => 'Hello, world!',
    '/posts/{post_id}' => fn($params) => $post->show($params),
  ],
  'POST' => [
    '/login' => fn() => $auth->login(),
  ],
];

```

Routes are matched using regex, to use named capture groups.

## Templates

Create a `templates/` directory in the project root like this. You can also structure them by putting them in seperating folders.

```
templates/
├── layouts/
    ├── app.phtml
    └── admin.phtml
├── admin/posts/
    └── edit.phtml
├── home.phtml
└── about.phtml
```

Templates can be rendered from anywhere using the `Engine`.

```php
$engine = new Feather\Engine();

return [
  'GET' => [
    '/' => fn() => $engine->render('home'),
    '/' => fn() => $engine->render('admin/posts/edit'),
  ]
];
```

The actual syntax of the templates is highly inspired by Blade. If you are used to writing Blade or CakePHP templates, you'll feel pretty much at home. This template extends the `layouts/app.phtml` template and renders the content inside the content section in its designated place.

```php
<?php $this->extend('layouts/app'); ?>
<?php $this->start('content'); ?>
  <div>
    My awesome website!
  </div>
<?php $this->end(); ?>
```

To understand this further, lets also take a look at the template we're extending here. This is basically just a bare html setup. And just like in Laravel or Cake we can also include different templates that we want to have in a different place using the include.

```php
<body class="bg-gray-950 text-white container mx-auto">
    <header class="mb-8">
        <?= $this->include('partials/nav') ?>
    </header>
    <main>
        <?= $this->yield('content') ?>
    </main>
    <footer class="mt-8">
        <?= $this->include('partials/footer') ?>
    </footer>
</body>
```

At the moment:

- Templates must be located inside `templates/`
- Templates must use the `.phtml` extension
- Templates should contain a complete HTML document
- Some default templates, like `404` are located in the frameworks directory

## Caching

A very simplified version of Caching any form of data in the json format. This is a component that is very optional and completely independent. 

The cached data gets stored in your projects' root directory in the `cache/` directory as `{cache_name}.cache`. Therefore the cached data can be retrieved from anywhere in your project.

You can Cache data and retrieve it again by simply doing this:

```php
<?php

use Feather\Cache;

$my_data = [
  'test' => true,
  'dataset' [
    'new' => true,
    'creation_time' => time(),
    'data' => [
      1, 2, 3, 4
    ]
  ]
]

Cache::cacheData('my_data', json_encode($my_data));

$my_cached_data = Cache::get('my_data');
```

## Project Structure

A Feather Project should look something like this:

```text
my-app/
├── public/
│   └── index.php
├── templates/
│   └── home.phtml
├── routes.php
├── development.php
├── vendor/
├── src/
└── composer.json
```
