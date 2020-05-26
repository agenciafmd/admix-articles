<?php

namespace Agenciafmd\Articles;

use Agenciafmd\Categories\Category as CategoryBase;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Category extends CategoryBase implements Searchable
{
    protected $table = 'categories';

    protected $attributes = [
        'type' => 'articles-categories',
    ];

    public $searchableType;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->searchableType = config('admix-categories.articles-categories.name');
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            "{$this->name} ({$this->email})",
            route('admix.articles.categories.edit', $this->id)
        );
    }

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
