<?php

namespace Agenciafmd\Articles\Models;

use Agenciafmd\Articles\Database\Factories\ArticleFactory;
use Agenciafmd\Media\Traits\MediaTrait;
use Agenciafmd\Admix\Traits\TurboTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Article extends Model implements AuditableContract, HasMedia, Searchable
{
    use SoftDeletes, HasFactory, Auditable, MediaTrait, TurboTrait;

    protected $guarded = [
        'media',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public $searchableType;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->searchableType = config('admix-articles.name');
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            "{$this->name}",
            route('admix.articles.edit', $this->id)
        );
    }

    public function category()
    {
        if (config('admix-articles.category')) {
            return $this->belongsTo(Category::class);
        }

        return null;
    }

    public function getUrlAttribute()
    {
        if (config('admix-articles.category')) {
            return route('frontend.articles.show', [
                $this->category->slug, $this->attributes['slug'],
            ]);
        }

        return route('frontend.articles.show', [
            $this->attributes['slug'],
        ]);
    }

    public function scopeIsActive($query)
    {
        $query->where('is_active', 1)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', Carbon::now());
            });
    }

    public function setPublishedAtAttribute($value)
    {
        if (!$value) {
            return null;
        }

        $this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $value)
            ->format('Y-m-d H:i:s');
    }

    public function scopeSort($query)
    {
        $sorts = default_sort(config('admix-articles.default_sort'));

        foreach ($sorts as $sort) {
            $query->orderBy($sort['field'], $sort['direction']);
        }
    }

    protected static function newFactory()
    {
        if (class_exists(\Database\Seeders\ArticleFactory::class)) {
            return \Database\Seeders\ArticleFactory::new();
        }

        return ArticleFactory::new();
    }
}
