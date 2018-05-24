<?php

namespace Agencms\Pages\Handlers;

use Agencms\Core\Field;
use Agencms\Core\Group;
use Agencms\Core\Route;
use Agencms\Core\Option;
use Agencms\Core\Relationship;
use Agencms\Core\Facades\Agencms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Agencms\Pages\Middleware\AgencmsConfig;
use Illuminate\Support\Facades\Route as Router;

class AgencmsHandler
{
    /**
     * Register router middleware as plugin for Agencms.
     *
     * @return void
     */
    public static function register()
    {
        Router::aliasMiddleware('agencms.pages', AgencmsConfig::class);
        Agencms::registerPlugin('agencms.pages');
    }

    /**
     * Register all routes and models for the Admin GUI (AUI)
     *
     * @return void
     */
    public static function registerAdmin()
    {
        if (!Gate::allows('admin_access')) {
            return;
        }

        self::registerAgencms();
    }

    /**
     * Register the Agencms endpoints for this Application
     *
     * @return void
     */
    public static function registerAgencms()
    {
        if (!Gate::allows('pages_read')) {
            return;
        }

        Agencms::registerRoute(
            Route::init('pages', ['Pages' => 'All Pages'], '/agencms/pages')
                ->icon('person')
                ->addGroup(
                    Group::large('Configuration')->addField(
                        Field::string('title', 'Title')->required()->list()
                    )
                )
        );
    }
}
