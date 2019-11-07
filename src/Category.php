<?php

namespace Agenciafmd\Articles;

use Agenciafmd\Categories\Category as CategoryBase;
use Illuminate\Database\Eloquent\Builder;

class Category extends CategoryBase
{
    protected $table = 'categories';

    protected $attributes = [
        'type' => 'articles-categories',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'articles-categories');
        });
    }

    public function getUrlAttribute()
    {
        return route('frontend.articles.index', [
            $this->attributes['slug'],
        ]);
    }
}
