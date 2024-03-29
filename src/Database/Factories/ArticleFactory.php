<?php

namespace Agenciafmd\Articles\Database\Factories;

use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Articles\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        $videos = [
            'https://youtu.be/t7Fsj8NSmJc',
            'https://youtu.be/sxRsOtovv2g',
            'https://youtu.be/RzaT7uijAis',
            'https://youtu.be/lfRcP3SdxMg',
            'https://youtu.be/HsQx02JdZ2Q',
            'https://youtu.be/WauIURFTpEc',
            'https://youtu.be/HziP2v9gfCg',
            'https://youtu.be/Z4Kz50LFiZk',
        ];

        $categories = Category::pluck('id')
            ->toArray();

        return [
            'is_active' => $this->faker->optional(0.3, 1)
                ->randomElement([0]),
            'star' => $this->faker->optional(0.3, 1)
                ->randomElement([0]),
            'category_id' => config('admix-articles.category') ? $this->faker->randomElement($categories) : 0,
            'name' => $this->faker->sentence(),
            'call' => config('admix-articles.call') ? $this->faker->sentence() : null,
            'short_description' => config('admix-articles.short_description') ? (config('admix-articles.wysiwyg') ? "<p>{$this->faker->paragraph}</p>" : $this->faker->paragraph) : null,
            'description' => config('admix-articles.wysiwyg') ? '<p>' . collect($this->faker->paragraphs(5, false))->implode('</p><p>') . '</p>' : $this->faker->paragraphs(5, true),
            'video' => config('admix-articles.video') ? $this->faker->randomElement($videos) : null,
            'published_at' => config('admix-articles.published_at') ? $this->faker->dateTimeBetween('-15 days', '15 days')
                ->format('Y-m-d\TH:i') : null,
        ];
    }
}