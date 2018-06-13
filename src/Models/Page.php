<?php

namespace Agencms\Pages\Models;

use Agencms\Settings\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Page extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'content',
        'structured_data',
        'image',
        'published',
        'summary',
        'priority',
    ];

    protected $casts = [
        'content' => 'array',
        'structured_data' => 'array',
        'published' => 'boolean',
    ];

    public function scopePrioritised(Builder $query)
    {
        return $query->orderByDesc('priority');
    }

    public function scopeIsHomepage(Builder $query)
    {
        return $query->where('id', Settings::get('global', 'homepage', 0));
    }

    public function scopeIsNotHomepage(Builder $query)
    {
        return $query->where('id', '!=', Settings::get('global', 'homepage', 0));
    }
}
