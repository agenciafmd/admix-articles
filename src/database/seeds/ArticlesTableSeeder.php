<?php

use Agenciafmd\Articles\Article;
use Agenciafmd\Articles\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesTableSeeder extends Seeder
{
    protected $total = 50;

    public function run()
    {
        Article::withTrashed()
            ->get()->each->forceDelete();

        DB::table('media')
            ->where('model_type', 'Agenciafmd\\Articles\\Article')
            ->delete();

        $faker = Faker\Factory::create('pt_BR');

        $categories = Category::pluck('id');

        $this->command->getOutput()
            ->progressStart($this->total);
        factory(Article::class, $this->total)
            ->create()
            ->each(function ($article) use ($faker, $categories) {

                foreach (config('upload-configs.article') as $key => $image) {
                    $fakerDir = __DIR__ . '/../faker/' . $key;

                    if ($image['faker_dir']) {
                        $fakerDir = $image['faker_dir'];
                    }

                    if ($image['multiple']) {
                        $items = $faker->numberBetween(0, 6);
                        for ($i = 0; $i < $items; $i++) {
                            $article->doUploadMultiple($faker->file($fakerDir, storage_path('admix/tmp')), $key);
                        }
                    } else {
                        $article->doUpload($faker->file($fakerDir, storage_path('admix/tmp')), $key);
                    }
                }

                if (config('admix-articles.download')) {
                    $article->doUpload($faker->file(__DIR__ . '/../faker/download', storage_path('admix/tmp')), 'download');
                }

                $article->category_id = ($faker->randomElement($categories)) ?? 0;

                $article->save();

                $this->command->getOutput()
                    ->progressAdvance();
            });
        $this->command->getOutput()
            ->progressFinish();
    }
}
