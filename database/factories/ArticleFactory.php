<?php

namespace Agenciafmd\Articles\Database\Factories;

use Agenciafmd\Articles\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $videos = [
            'https://youtu.be/NIkJFjaWgi8',
            'https://youtu.be/PDQXIFKOYDQ',
            'https://youtu.be/wT4KGQH4E1M',
            'https://youtu.be/QVlTuInyZKk',
            'https://youtu.be/JvGXFeDDBkE',
        ];

        return [
            'is_active' => $this->faker->optional(0.3, 1)
                ->randomElement([0]),
            'star' => $this->faker->optional(0.2, 1)
                ->randomElement([0]),
            'name' => $this->faker->sentence(3),
            'call' => config('admix-articles.call') ? $this->faker->sentence() : null,
            'author' => config('admix-articles.author') ? $this->faker->name : null,
            'short_description' => config('admix-articles.short_description') ? $this->faker->sentence(6) : null,
            'description' => $this->faker->text,
            'video' => config('admix-articles.video') ? $this->faker->randomElement($videos) : null,
            'published_at' => config('admix-articles.published_at') ? $this->faker->dateTimeBetween('-15 days', '15 days')
                ->format('Y-m-d\TH:i') : null,
            'sort' => null,
        ];
    }
}
