<?php

namespace Agenciafmd\Articles\Livewire\Pages\Article;

use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Support\Helper;
use Agenciafmd\Support\Rules\YoutubeUrl;
use Agenciafmd\Ui\Traits\WithMediaSync;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form as LivewireForm;

class Form extends LivewireForm
{
    use WithMediaSync;

    public Article $article;

    #[Validate]
    public bool $is_active = true;

    #[Validate]
    public bool $star = false;

    #[Validate]
    public string $name = '';

    #[Validate]
    public ?string $author = null;

    #[Validate]
    public ?string $call = null;

    #[Validate]
    public ?string $short_description = null;

    #[Validate]
    public ?string $video = null;

    #[Validate]
    public ?string $description = null;

    #[Validate]
    public array $image_files = [];

    #[Validate]
    public array $image_meta = [];

    #[Validate]
    public Collection $image;

    #[Validate]
    public array $gallery_files = [];

    #[Validate]
    public array $gallery_meta = [];

    #[Validate]
    public Collection $gallery;

    #[Validate]
    public ?string $published_at = '';

    #[Validate]
    public ?int $sort = null;

    public function setModel(Article $article): void
    {
        $this->article = $article;
        $this->image = collect();
        $this->image_meta = [];
        $this->gallery = collect();
        $this->gallery_meta = [];
        if ($article->exists) {
            $this->is_active = $article->is_active;
            $this->star = $article->star;
            $this->name = $article->name;
            $this->author = $article->author;
            $this->call = $article->call;
            $this->short_description = $article->short_description;
            $this->video = $article->video;
            $this->description = $article->description;
            $this->image = $article->image;
            $this->image_meta = $this->image->pluck('meta')
                ->toArray();
            $this->gallery = $article->gallery;
            $this->gallery_meta = $this->gallery->pluck('meta')
                ->toArray();
            $this->published_at = $article->published_at?->format('Y-m-d\TH:i');
            $this->sort = $article->sort;
        }
    }

    public function rules(): array
    {
        $rules = [
            'is_active' => [
                'required',
                'boolean',
            ],
            'star' => [
                'required',
                'boolean',
            ],
            'name' => [
                'required',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
            ],
            'sort' => [
                'nullable',
                'integer',
            ],
        ];

        if (config('admix-articles.author')) {
            $rules['author'] = [
                'required',
                'max:255',
            ];
        }

        if (config('admix-articles.call')) {
            $rules['call'] = [
                'required',
                'max:255',
            ];
        }

        if (config('admix-articles.short_description')) {
            $rules['short_description'] = [
                'nullable',
                'max:255',
            ];
        }

        if (config('admix-articles.video')) {
            $rules['video'] = [
                'required',
                'string',
                new YoutubeUrl,
            ];
        }

        if (config('admix-articles.published_at')) {
            $rules['published_at'] = [
                'required',
                'date_format:Y-m-d\TH:i',
            ];
        }

        if (config('admix-articles.image')) {
            $rules['image_files.*'] = [
                'image',
                'max:' . config('admix-articles.image.max'),
                Rule::dimensions()
                    ->maxWidth(config('admix-articles.image.max_width'))
                    ->maxHeight(config('admix-articles.image.max_height')),
            ];
            $rules['image'] = [
                'array',
                'nullable',
            ];
            $rules['image_meta'] = [
                'array',
            ];
        }

        if (config('admix-articles.gallery')) {
            $rules['gallery_files.*'] = [
                'image',
                'max:' . config('admix-articles.gallery.max'),
                Rule::dimensions()
                    ->maxWidth(config('admix-articles.gallery.max_width'))
                    ->maxHeight(config('admix-articles.gallery.max_height')),
            ];
            $rules['gallery'] = [
                'array',
                'nullable',
            ];
            $rules['gallery_meta'] = [
                'array',
            ];
        }

        return $rules;
    }

    public function prepareForValidation($attributes): array
    {
        if (config('admix-articles.video')) {
            $this->video = $attributes['video'] = Helper::sanitizeYoutube($this->video) ?: $this->video;
        }

        return $attributes;
    }

    public function validationAttributes(): array
    {
        return [
            'is_active' => __('admix-articles::fields.is_active'),
            'star' => __('admix-articles::fields.star'),
            'name' => __('admix-articles::fields.name'),
            'author' => __('admix-articles::fields.author'),
            'call' => __('admix-articles::fields.call'),
            'short_description' => __('admix-articles::fields.short_description'),
            'description' => __('admix-articles::fields.description'),
            'image' => __('admix-articles::fields.image'),
            'image_files.*' => __('admix-articles::fields.image'),
            'image_meta' => __('admix-articles::fields.image'),
            'gallery' => __('admix-articles::fields.gallery'),
            'gallery_files.*' => __('admix-articles::fields.gallery'),
            'gallery_meta' => __('admix-articles::fields.gallery'),
            'video' => __('admix-articles::fields.video'),
            'published_at' => __('admix-articles::fields.published_at'),
            'sort' => __('admix-articles::fields.sort'),
        ];
    }

    public function save(): bool
    {
        $this->validate(rules: $this->rules(), attributes: $this->validationAttributes());
        $this->article->fill($this->except([
            'article',
            'image',
            'image_files',
            'image_meta',
            'gallery',
            'gallery_files',
            'gallery_meta',
        ]));

        if (!$this->article->exists) {
            $this->article->save();
        }

        if (config('admix-articles.image')) {
            $this->syncMedia($this->article, 'image');
        }

        if (config('admix-articles.gallery')) {
            $this->syncMedia($this->article, 'gallery');
        }

        return $this->article->save();
    }
}
