<?php

namespace Agenciafmd\Articles\Models;

use Agenciafmd\Admix\Traits\WithScopes;
use Agenciafmd\Admix\Traits\WithSlug;
use Agenciafmd\Articles\Database\Factories\ArticleFactory;
use Agenciafmd\Ui\Casts\AsMediaLibrary;
use Agenciafmd\Ui\Casts\AsSingleMediaLibrary;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements AuditableContract, HasMedia
{
    use Auditable, HasFactory, InteractsWithMedia, Prunable, SoftDeletes, WithScopes, WithSlug;

    protected $fillable = [
        'is_active',
        'star',
        'name',
        'author',
        'call',
        'short_description',
        'video',
        'description',
        'published_at',
        'sort',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'star' => 'boolean',
        'published_at' => 'datetime',
        'image' => AsSingleMediaLibrary::class,
        'gallery' => AsMediaLibrary::class,
    ];

    protected array $defaultSort = [
        'is_active' => 'desc',
        'star' => 'desc',
        'sort' => 'asc',
        'published_at' => 'desc',
        'name' => 'asc',
    ];

    public function prunable(): Builder
    {
        return self::where('deleted_at', '<=', now()->subYear());
    }

    protected static function newFactory(): ArticleFactory|\Database\Factories\ArticleFactory
    {
        if (class_exists(\Database\Factories\ArticleFactory::class)) {
            return \Database\Factories\ArticleFactory::new();
        }

        return ArticleFactory::new();
    }
}
