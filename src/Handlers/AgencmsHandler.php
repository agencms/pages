<?php

namespace Agencms\Pages\Handlers;

use Agencms\Core\Field;
use Agencms\Core\Group;
use Agencms\Core\Route;
use Agencms\Core\Option;
use Agencms\Core\Relationship;
use Agencms\Core\Facades\Agencms;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Agencms\Pages\Middleware\AgencmsConfig;
use Illuminate\Support\Facades\Route as Router;
use Agencms\Pages\Handlers\ContentRepeaterHandler;
use Agencms\StructuredData\Facades\StructuredData;

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
        self::registerSettings();
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
                ->icon('file_copy')
                ->addGroup(
                    Group::full('Details')->addField(
                        Field::string('name', 'Name')
                            ->medium()->required()->list()->link('slug'),
                        Field::string('slug', 'Slug')
                            ->medium()->required()->list()->slug(),
                        Field::number('priority', 'Priority')
                            ->medium()->required()->list(),
                        Field::boolean('published', 'Published')
                            ->medium()->required()->list(),
                        Field::string('summary', 'Summary')
                                ->medium()->multiline(15),
                        Field::image('image', 'Featured Image')
                            ->medium()->ratio(1280, 630, $resize = true)
                    ),
                    Group::full('Content')
                        ->repeater('content')
                        ->addGroup(...App::make(config('agencmspages.content_repeaters'))::get()),
                    StructuredData::repeater()
                )
        );
    }

    /**
     * Append the general settings with additional settings for the Pages plugin
     *
     * @return void
     */
    public static function registerSettings()
    {
        if (!Gate::allows('settings_read')) {
            return;
        }

        Agencms::appendRoute(
            Route::load('settings')
                ->addGroup(
                    Group::full('Header')->key('header')->addField(
                        Field::string('title', 'Title'),
                        Field::string('twitter-handle', 'Twitter Handle'),
                        Field::string('github-handle', 'Github Handle')
                    ),
                    Group::full('Homepage')->key('homepage')->addField(
                        Field::related('homepage', 'Homepage')
                            ->model(
                                Relationship::make('pages')
                            )
                    ),
                    Group::full('Social Links')->repeater('sociallinks')
                        ->addGroup(
                            Group::full('Link')->key('sociallink')->addField(
                                Field::select('network', 'Network')
                                    ->dropdown()
                                    ->addOptions([
                                        'Codepen',
                                        'Facebook',
                                        'Github',
                                        'Instagram',
                                        'LinkedIn',
                                        'Twitter',
                                    ])
                                    ->small(),
                                Field::string('url', 'Url')
                                    ->large()
                            )
                        ),
                    Group::full('Footer')->key('footer')->addField(
                        Field::string('copyright', 'Copyright Notice')
                    ),
                    Group::full('Defaults')->key('defaults')->addField(
                        Field::image('sharingimage', 'Default Sharing Image')
                            ->ratio(1200, 630, true)
                    ),
                    Group::full('Config')->key('config')->addField(
                        Field::string('ga_code', 'Google Analytics Id')
                    )
                )
        );
    }
}
