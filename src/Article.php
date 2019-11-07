<?php

namespace Agenciafmd\Articles;

use Agenciafmd\Admix\MediaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Article extends Model implements AuditableContract, HasMedia
{
    use SoftDeletes, Auditable, HasMediaTrait, MediaTrait {
        MediaTrait::registerMediaConversions insteadof HasMediaTrait;
    }

    protected $guarded = [
        'media',
    ];

    protected $dates = [
        'published_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });
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
            ->where('published_at', '<=', Carbon::now());
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
}
