<?php

namespace Agenciafmd\Articles\Models;

use Agenciafmd\Admix\Traits\WithScopes;
use Agenciafmd\Admix\Traits\WithSlug;
use Agenciafmd\Articles\Database\Factories\ArticleFactory;
use Agenciafmd\Articles\Observers\ArticleObserver;
use Agenciafmd\Categories\Traits\WithCategories;
use Agenciafmd\Ui\Casts\AsMediaLibrary;
use Agenciafmd\Ui\Casts\AsSingleMediaLibrary;
use Agenciafmd\Ui\Traits\WithUpload;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy([ArticleObserver::class])]
class Article extends Model implements AuditableContract, HasMedia
{
    use Auditable, HasFactory, InteractsWithMedia, Prunable, SoftDeletes, WithCategories, WithScopes, WithSlug, WithUpload;

    protected array $defaultSort = [
        'is_active' => 'desc',
        'star' => 'desc',
        'sort' => 'asc',
        'published_at' => 'desc',
        'name' => 'asc',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'star' => 'boolean',
            'published_at' => 'datetime',
            'image' => AsSingleMediaLibrary::class,
            'gallery' => AsMediaLibrary::class,
        ];
    }

    protected function frontDescription(): Attribute
    {
        return Attribute::make(
            get: static fn (mixed $value, $attributes) => str($attributes['description'])->markdown([
                'allow_unsafe_links' => false,
            ]),
        );
    }

    public function prunable(): Builder
    {
        return static::query()->where('deleted_at', '<=', now()->subYear());
    }

    protected static function newFactory(): ArticleFactory|\Database\Factories\ArticleFactory
    {
        if (class_exists(\Database\Factories\ArticleFactory::class)) {
            return \Database\Factories\ArticleFactory::new();
        }

        return ArticleFactory::new();
    }
}
