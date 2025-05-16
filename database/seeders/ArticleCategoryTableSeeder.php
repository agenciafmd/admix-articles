<?php

namespace Agenciafmd\Articles\Database\Seeders;

use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Categories\Models\Category;
use Illuminate\Database\Seeder;

class ArticleCategoryTableSeeder extends Seeder
{
    protected int $total = 100;

    protected string $type = 'categories';

    protected string $model = Article::class;

    public function run(): void
    {
        Category::query()
            ->where('type', $this->type)
            ->where('model', $this->model)
            ->get()
            ->each
            ->delete();

        if (!config('admix-articles.category')) {
            return;
        }

        collect(range(1, $this->total))
            ->each(function () {
                Category::factory()
                    ->create([
                        'type' => $this->type,
                        'model' => $this->model,
                    ]);
            });
    }
}
