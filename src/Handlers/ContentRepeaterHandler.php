<?php

namespace Agencms\Pages\Handlers;

use Agencms\Core\Field;
use Agencms\Core\Group;
use Agencms\Core\Relationship;
use Agencms\Core\Contracts\RepeaterHandlerContract;

class ContentRepeaterHandler implements RepeaterHandlerContract
{
    protected $repeaters;

    public function __construct()
    {
        $this->repeaters = array_merge(
            $this->getPrependRepeaters(),
            $this->getDefaultRepeaters(),
            $this->getAppendRepeaters()
        );
    }

    public function getDefaultRepeaters()
    {
        return [
            Group::full('Lead')
                ->key('pages.lead')
                ->addField(
                    Field::image('image', 'Image')
                        ->ratio(1280, 800, $resize = true),
                    Field::string('title', 'Title'),
                    Field::string('subtitle', 'Subtitle')
                ),
            Group::full('Text')
                ->key('pages.text')
                ->addField(
                    Field::string('text', 'Text')
                        ->multiline()
                ),
            Group::full('Image')
                ->key('pages.image')
                ->addField(
                    Field::image('image', 'Image')
                        ->ratio(1280, 800, $resize = true),
                    Field::string('alt', 'Alternative Text'),
                    Field::string('href', 'Link Target')
                ),
            Group::full('Related')
                ->key('pages.related')
                ->addField(
                    Field::related('related', 'Pages')
                        ->model(Relationship::make('pages'))
                        ->multiple()
                )
        ];
    }

    public function getPrependRepeaters()
    {
        return [];
    }

    public function getAppendRepeaters()
    {
        return [];
    }

    public static function get()
    {
        return (new static)->repeaters;
    }
}
