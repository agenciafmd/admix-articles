<?php

namespace Agenciafmd\Articles\Database\Seeders;

use Agenciafmd\Articles\Models\Article;
use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    protected int $total = 20;

    public function run(): void
    {
        Article::query()
            ->truncate();

        //        $this->command->getOutput()
        //            ->progressStart($this->total);

        collect(range(1, $this->total))
            ->each(function () {
                $factory = Article::factory()->withMedia();

                if (config('admix-articles.category')) {
                    $factory = $factory->withCategory();
                }

                $factory->create();

                //                $this->command->getOutput()
                //                    ->progressAdvance();
            });

        //        $this->command->getOutput()
        //            ->progressFinish();
    }
}
