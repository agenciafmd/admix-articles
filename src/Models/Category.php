<?php

namespace Agenciafmd\Articles\Models;

use Agenciafmd\Articles\Database\Factories\ArticleCategoryFactory;
use Agenciafmd\Categories\Models\Category as CategoryBase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Category extends CategoryBase implements Searchable
{
    use HasFactory;

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

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'articles-categories');
        });
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            "{$this->name}",
            route('admix.articles.categories.edit', $this->id)
        );
    }

    public function getUrlAttribute()
    {
        return route('frontend.articles.index', [
            $this->attributes['slug'],
        ]);
    }

    public function scopeSort($query, $type = 'articles-categories'): void
    {
        parent::scopeSort($query, $type);
    }

    protected static function newFactory()
    {
        if (class_exists(\Database\Factories\ArticleCategoryFactory::class)) {
            return \Database\Factories\ArticleCategoryFactory::new();
        }

        return ArticleCategoryFactory::new();
    }
}
