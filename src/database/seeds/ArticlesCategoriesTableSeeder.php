<?php

use Agenciafmd\Articles\Category;
use Illuminate\Database\Seeder;

class ArticlesCategoriesTableSeeder extends Seeder
{
    protected $total = 10;

    public function run()
    {
        Category::withTrashed()
            ->where('type', 'articles-categories')
            ->get()->each->forceDelete();

        if (!config('admix-articles.category')) {
            return false;
        }

        if (config('admix-categories.articles-categories.items')) {
            $this->staticItems();

            return false;
        }

        $this->factoryItems();

    }

    private function factoryItems()
    {
        $this->command->getOutput()
            ->progressStart($this->total);
        factory(Category::class, $this->total)
            ->create()
            ->each(function () {
                $this->command->getOutput()
                    ->progressAdvance();
            });
        $this->command->getOutput()
            ->progressFinish();
    }

    private function staticItems()
    {
        $items = collect(config('admix-categories.articles-categories.items'));

        $this->command->getOutput()
            ->progressStart($items->count());
        $items->each(function ($item) {
            Category::create([
                'is_active' => '1',
                'name' => $item,
            ]);
            $this->command->getOutput()
                ->progressAdvance();
        });
        $this->command->getOutput()
            ->progressFinish();

    }
}
