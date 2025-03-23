<?php

namespace Enraiged;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     *  Bootstrap any application services.
     *
     *  @return void
     */
    public function boot()
    {
        AboutCommand::add('Enraiged', fn () => ['Version' => config('enraiged.version')]);

        $this->bootInstall();

        $this->bootPublish();
    }

    /**
     *  Bootstrap the install services.
     *
     *  @return void
     */
    protected function bootInstall(): void
    {
        //
    }

    /**
     *  Bootstrap the publish services.
     *
     *  @return void
     */
    protected function bootPublish(): void
    {
        $this->publishes(
            [__DIR__.'/../publish/app' => base_path('app')],
            ['enraiged', 'enraiged-core', 'enraiged-core-app'],
        );

        $this->publishes(
            [__DIR__.'/../publish/app/Http/Controllers' => base_path('app/Http/Controllers')],
            ['enraiged-core-controllers'],
        );

        $this->publishes(
            [__DIR__.'/../publish/app/Http/Middleware' => base_path('app/Http/Middleware')],
            ['enraiged-core-middleware'],
        );

        $this->publishes(
            [__DIR__.'/../publish/app/Http/Requests' => base_path('app/Http/Requests')],
            ['enraiged-core-requests'],
        );

        $this->publishes(
            [__DIR__.'/../publish/bootstrap' => base_path('bootstrap')],
            ['enraiged', 'enraiged-core', 'enraiged-core-bootstrap'],
        );

        $this->publishes(
            [__DIR__.'/../publish/config/enraiged' => config_path('enraiged')],
            ['enraiged', 'enraiged-core', 'enraiged-core-config'],
        );

        $this->publishes(
            [__DIR__.'/../publish/database' => database_path()],
            ['enraiged', 'enraiged-core', 'enraiged-core-database'],
        );

        $this->publishes(
            [__DIR__.'/../publish/database/migrations' => database_path('migrations')],
            ['enraiged-core-migrations'],
        );

        $this->publishes(
            [__DIR__.'/../publish/database/seeders' => database_path('seeders')],
            ['enraiged-core-seeders'],
        );

        $this->publishes(
            [__DIR__.'/../publish/lang' => base_path('lang')],
            ['enraiged', 'enraiged-core', 'enraiged-lang'],
        );

        $this->publishes(
            [__DIR__.'/../publish/resources' => resource_path()],
            ['enraiged', 'enraiged-core', 'enraiged-core-resources'],
        );

        $this->publishes(
            [__DIR__.'/../publish/resources/seeds' => resource_path('seeds')],
            ['enraiged-core-seeds'],
        );

        $this->publishes(
            [__DIR__.'/../publish/resources/views' => resource_path('views')],
            ['enraiged-core-views'],
        );

        $this->publishes(
            [__DIR__.'/../publish/resources/views/mail' => resource_path('views/mail')],
            ['enraiged-core-mail-views'],
        );

        $this->publishes(
            [__DIR__.'/../publish/routes' => base_path('routes')],
            ['enraiged', 'enraiged-core', 'enraiged-core-routes'],
        );
    }
}
