# Site: Playground API and Angular SPA Integration

[![Playground CI Workflow](https://github.com/gammamatrix/site-api-angular/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/site-api-angular/testing/develop/testdox.txt)
[![Test Coverage](https://img.shields.io/badge/coverage-%2087%25-brightgreen)]([tests](https://raw.githubusercontent.com/gammamatrix/site-api-angular/testing/develop/testdox.txt))


Site: Playground API and Angular SPA Integration Package for [Laravel v11](https://laravel.com/docs/11.x) and [Angular v16, v17, v18](https://angular.dev/) applications.

Read more on using [Site: Playground API and Angular SPA Integration at Read the Docs: Playground Documentation.](https://gammamatrix-playground.readthedocs.io/en/develop/)

## Angular Application

Currently, there is only one Angular Application.

#### Site: Playground CMS UI with Angular

[gammamatrix/site-playground-cms-angular](https://github.com/gammamatrix/site-playground-cms-angular)

## Dev Notes

A base Laravel installation was used.

```sh
composer create-project laravel/laravel site-api-angular
```

### Enabled Sanctum

Added `Laravel\Sanctum\HasApiTokens` to the [User](app/Models/User.php) model.

```sh
php artisan install:api
php artisan config:publish cors
```

```conf
SESSION_DOMAIN=site-api-angular
# SESSION_DOMAIN=site-playground-integration
SESSION_HTTP_ONLY=false
SESSION_SECURE_COOKIE=false

SANCTUM_STATEFUL_DOMAINS=site-api-angular
```

```sh
composer require gammamatrix/playground-cms-api
```
- composer.json need to allow `"minimum-stability": "dev",`

## nginx configuration for the PHP API and Angular app

[resources/configuration/31010-site-api-angular.conf](resources/configuration/31010-site-api-angular.conf)
- Note development is done on http with scheme-less URLs, where possible.