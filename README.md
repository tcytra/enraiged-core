# Enraiged Core

Enraiged Core is the core library required by various Enraiged Laravel projects.

## About Enraiged

> **Please Note:** This library is currently a work in progress and not yet ready for production use.

The Enraiged system is built atop the Laravel framework and is intended to provide various additional features and 
functionality to simplify initial project set-up and readiness.

The driving philosophy behind Enraiged is to **help, not hinder** the developer in getting a project from first install
through to production.

## Install Enraiged Core

> **Please Note:** At the current time it is not recommended to manually require enraiged-core into a fresh install of
Laravel. **The ability to install/publish the necessary files is incomplete.**

Enraiged Core is an aggregate library containing the core systems for Enraiged projects. It is recommended to use the 
[Enraiged Breeze](https://github.com/tcytra/enraiged-breeze) or 
[Enraiged Laravel](https://github.com/tcytra/enraiged-laravel) repositories available on Github.

That said, you may use composer to manually install Enraiged Core into your Laravel project:

```sh
composer require tcytra/enraiged-core
```

Then, use Laravel Artisan to publish the Enraiged Core assets to your project:

```sh
php artisan vendor:publish --tag=enraiged-core --ansi --force
```

## License

The Enraiged Core library is open-sourced software licensed under the [MIT license](LICENSE.md).
