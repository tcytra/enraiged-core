# Enraiged Core

**Enraiged Core provides the user/authentication systems required by Enraiged Laravel projects.**

> **Please Note:** This package is currently a work in progress and not yet ready for production use.

Enraiged Core is an aggregate library containing the core systems for Enraiged projects for handling users and 
authtication. This package will update the default `users` database table with additional columns and create other 
tables to provide a more robust set of available features and options for your Laravel project.

It may be prefereable to use the [Enraiged Laravel](https://github.com/tcytra/enraiged-laravel) package, which is 
effectively an install of Enraiged Core into a new Laravel/Laravel project, with all assets published and a Vue 
front-end driven by Inertia.js.


## Usage

Install the Enraiged Core package to your Laravel project using composer:

```sh
composer require tcytra/enraiged-core
```

Publish the Enraiged Core assets to the local project:

```sh
rm resources/views/welcome.blade.php &&
rm database/factories/UserFactory.php &&
rmdir database/factories &&
php artisan vendor:publish --tag=enraiged-core --ansi --force
```


## License

The Enraiged Core library is open-sourced software licensed under the [MIT license](LICENSE.md).
