# Nano PHP

A minimal PHP microframework. No magic, no bloat — just routing, controllers, views, and a few security essentials.

**Author:** Vlado Majoros, [4aSuite](https://4asuite.com)
**License:** MIT

---

## Requirements

- PHP **^8.1**
- Apache with `mod_rewrite` (or equivalent front-controller setup)
- No external dependencies for the core

---

## Installation

```bash
composer create-project 4afw/4afw myproject
cd myproject
```

Point your web server document root to the `public/` directory. Open the project in a browser — the welcome page confirms the framework is running.

---

## Project structure

```
myproject/
├── App/
│   ├── Config/
│   │   └── routes.php          # Route definitions
│   ├── Controllers/
│   │   └── NanofwController.php
│   ├── Core/                   # Framework core (do not modify)
│   │   ├── App.php
│   │   ├── Controller.php
│   │   ├── Csrf.php
│   │   ├── EnvLoader.php
│   │   ├── HttpException.php
│   │   ├── Lang.php
│   │   ├── Request.php
│   │   ├── Response.php
│   │   ├── Router.php
│   │   ├── Session.php
│   │   └── View.php
│   ├── Models/
│   │   └── Model.php           # Base PDO model
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── main.php
│   │   │   └── blank.php
│   │   └── partials/
│   │       └── head.php
│   └── bootstrap.php
├── public/
│   ├── index.php               # Front controller (web root)
│   └── .htaccess
├── .env
└── .env.example
```

---

## Configuration

Copy `.env.example` to `.env` and adjust as needed. Values are exposed as PHP constants.

```ini
APP_ENV=development
APP_DEFAULT_LANG=en

# Database (only if using Model)
DB.HOST=localhost
DB.NAME=mydb
DB.USER=root
DB.PASS=
```

Dot-notation keys (`DB.HOST`) are grouped into a single array constant `DB['HOST']`.

---

## Routing

Define routes in `App/Config/routes.php`:

```php
return [
    'GET' => [
        '/'             => [App\Controllers\HomeController::class, 'index'],
        '/users/(:num:id)' => [App\Controllers\UserController::class, 'show'],
        '/posts/(:any:slug)' => [App\Controllers\PostController::class, 'show'],
    ],
    'POST' => [
        '/users' => [App\Controllers\UserController::class, 'store'],
    ],
];
```

Route parameter types:

| Syntax | Matches | Example |
|---|---|---|
| `(:num:id)` | Digits only | `/users/42` |
| `(:any:slug)` | Any non-slash string | `/posts/hello-world` |

A missing route throws `HttpException(404)`, which the framework handles automatically.

---

## Controllers

Extend `App\Core\Controller`. Every action must return a `Response` instance.

```php
<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;

final class UserController extends Controller
{
    public function show(string $id): Response
    {
        return $this->view('users/show', ['id' => $id]);
    }

    public function store(): Response
    {
        $name = $this->request->post('name', '');
        // ...
        return $this->redirect('/users');
    }

    public function api(): Response
    {
        return $this->json(['status' => 'ok']);
    }
}
```

Available in every controller:

| Method | Description |
|---|---|
| `$this->request->get($key)` | GET parameter |
| `$this->request->post($key)` | POST parameter |
| `$this->request->input($key)` | POST or GET |
| `$this->request->method()` | HTTP method string |
| `$this->request->path()` | Normalized URL path |
| `$this->view($view, $data, $layout)` | Render view → Response |
| `$this->json($data, $status)` | JSON response |
| `$this->redirect($url, $code)` | Redirect (internal only) |

---

## Views

View files live in `App/views/`. Pass data as an associative array — keys become variables inside the template.

```php
// Controller
return $this->view('users/show', ['name' => 'Alice'], 'main');
```

```php
<!-- App/views/users/show.php -->
<h1><?= e($name) ?></h1>
```

Use the global `e()` helper to escape output (`htmlspecialchars` wrapper).

**Layouts** live in `App/views/layouts/`. The rendered view is passed as `$content`:

```php
<!-- App/views/layouts/main.php -->
<!DOCTYPE html>
<html lang="<?= e(APP_DEFAULT_LANG) ?>">
<head><?php require __DIR__ . '/../partials/head.php'; ?></head>
<body><?= $content ?></body>
</html>
```

Built-in layouts: `main` (full HTML5), `blank` (raw output, no wrapper).

---

## Session

```php
use App\Core\Session;

Session::set('user_id', 42);
$id  = Session::get('user_id');
$has = Session::has('user_id');
Session::remove('user_id');
Session::destroy();   // clears cookie + regenerates ID
```

Cookies are configured with `httponly`, `samesite=Lax`, `use_strict_mode`. `secure` flag is set automatically when HTTPS is detected.

---

## CSRF

```php
use App\Core\Csrf;

// In a view form:
<?= Csrf::input() ?>

// In a POST controller action:
Csrf::verify($this->request->post('_csrf'));   // throws HttpException(419) on failure
```

Token is 64-character hex (`random_bytes(32)`), stored in session, rotated on each verification.

---

## Language / Translations

```php
use App\Core\Lang;

Lang::load(['GREETING' => 'Hello, %s!']);

echo Lang::get('greeting', 'Alice');  // Hello, Alice!
```

Translation keys are uppercased and defined as PHP constants. Falls back to the key name if not defined.

---

## Security headers

Sent automatically on every response:

```
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
Referrer-Policy: strict-origin-when-cross-origin
Strict-Transport-Security: max-age=31536000; includeSubDomains
```

Override any header via `$this->response->header($key, $value)` before returning from the controller.

---

## HTTP errors

Throw `HttpException` from anywhere — the framework catches it and sends the appropriate HTTP status:

```php
use App\Core\HttpException;

throw new HttpException(403, 'Access denied.');
throw new HttpException(404, 'Not found.');
```

---

## License

MIT © Vlado Majoros, [4aSuite](https://4asuite.com)