<?php

namespace Agenciafmd\Articles\Database\Factories;

use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Categories\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
            'is_active' => fake()->optional(0.3, 1)
                ->randomElement([0]),
            'star' => fake()->optional(0.2, 1)
                ->randomElement([0]),
            'name' => fake()->sentence(3),
            'call' => config('admix-articles.call') ? fake()->sentence() : null,
            'author' => config('admix-articles.author') ? fake()->name : null,
            'short_description' => config('admix-articles.short_description') ? fake()->sentence(6) : null,
            'description' => fake()->text,
            'video' => config('admix-articles.video') ? fake()->randomElement($videos) : null,
            'published_at' => config('admix-articles.published_at') ? fake()->dateTimeBetween('-15 days', '15 days')
                ->format('Y-m-d\TH:i') : null,
            'sort' => null,
        ];
    }

    public function withMedia(): ArticleFactory
    {
        return $this->state(function (array $attributes) {
            return [
                //
            ];
        })
            ->afterCreating(function ($model) {
                collect(['image', 'gallery'])->each(function ($collection) use ($model) {
                    $fakerDir = base_path("database/faker/articles/files/{$collection}");
                    if (!File::isDirectory($fakerDir)) {
                        $fakerDir = __DIR__ . "/../faker/files/{$collection}";
                    }

                    if (collect(['image'])->contains($collection) && config('admix-articles.image')) {
                        $sourceFile = fake()->file($fakerDir, storage_path('media-library/temp'));
                        $targetFile = Storage::putFile('tmp', new HttpFile($sourceFile));
                        $model->doUpload($targetFile, $collection);
                    }

                    if (collect(['gallery'])->contains($collection) && config('admix-articles.gallery')) {
                        $items = fake()->numberBetween(0, 6);
                        for ($i = 0; $i < $items; $i++) {
                            $sourceFile = fake()->file($fakerDir, storage_path('media-library/temp'));
                            $targetFile = Storage::putFile('tmp', new HttpFile($sourceFile));
                            $model->doUpload($targetFile, $collection);
                        }
                    }
                });
            });
    }

    public function withTags(int $total = 10, string $type = 'tags'): Factory
    {
        $categories = Category::query()
            ->where('type', $type)
            ->where('model', $this->model)
            ->inRandomOrder()
            ->pluck('id');

        return $this->state(function (array $attributes) {
            return [
                //
            ];
        })->afterMaking(function (Article $article) {
            //
        })->afterCreating(function (Article $article) use ($type, $categories, $total) {
            $article->categories()
                ->where('model', $this->model)
                ->where('type', $type)
                ->attach($categories->random($total)->toArray(), [
                    'categoriable_type' => $this->model,
                    'type' => $type,
                ]);
        });
    }

    public function withCategory(string $type = 'categories'): Factory
    {
        return $this->withTags(1, $type);
    }
}
