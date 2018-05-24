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
    public function boot(Router $router, Kernel $kernel)
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        // $this->registerApiRoutes();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPermissions();
        AgencmsHandler::register();
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
