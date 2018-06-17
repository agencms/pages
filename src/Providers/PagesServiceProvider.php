<?php

namespace Agencms\Pages\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Agencms\Pages\Handlers\AgencmsHandler;
use Silvanite\Brandenburg\Traits\ValidatesPermissions;

class PagesServiceProvider extends ServiceProvider
{
    use ValidatesPermissions;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Migrations');
        $this->bootConfig();
        $this->bootViews();
        $this->registerApiRoutes();
        $this->registerWebRoutes();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerPermissions();
        AgencmsHandler::register();
    }

    /**
     * Publish the configuration file for editing within a project
     *
     * @return void
     */
    public function bootConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/agencmspages.php' => config_path('agencmspages.php'),
        ]);
    }

    /**
     * Load the package configuration to merge in with the App specific config
     *
     * @return void
     */
    public function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/agencmspages.php', 'agencmspages'
        );
    }

    /**
     * Load Agencms views used for rendering content
     *
     * @return void
     */
    private function bootViews()
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'agencms');
        $this->publishes([
            __DIR__.'/../Resources/Views' => resource_path('views/vendor/agencms'),
        ], 'views');
    }

    /**
     * Load Api Routes into the application
     *
     * @return void
     */
    private function registerApiRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
    }

    /**
     * Load Web Routes into the application
     *
     * @return void
     */
    private function registerWebRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }

    /**
     * Register default package related permissions
     *
     * @return void
     */
    private function registerPermissions()
    {
        collect([
            'pages_create',
            'pages_delete',
            'pages_read',
            'pages_update',
        ])->map(function ($permission) {
            Gate::define($permission, function ($user) use ($permission) {
                if ($this->nobodyHasAccess($permission)) {
                    return true;
                }
                return $user->hasRoleWithPermission($permission);
            });
        });
    }
}
