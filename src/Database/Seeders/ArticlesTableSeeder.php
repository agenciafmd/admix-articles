<?php

namespace Agenciafmd\Articles\Database\Seeders;

use Agenciafmd\Articles\Models\Article;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Facades\Storage;

class ArticlesTableSeeder extends Seeder
{
    protected int $total = 20;

    public function run()
    {
        Article::query()
            ->truncate();

        $this->command->getOutput()
            ->progressStart($this->total);

        $faker = Factory::create('pt_BR');

        Article::factory($this->total)
            ->create()
            ->each(function ($article) use ($faker) {

                foreach (config('upload-configs.article') as $key => $image) {
                    $fakerDir = __DIR__ . '/../Faker/articles/' . $key;

                    if ($image['faker_dir']) {
                        $fakerDir = $image['faker_dir'];
                    }

                    if ($image['multiple']) {
                        $items = $faker->numberBetween(0, 6);
                        for ($i = 0; $i < $items; $i++) {
                            $sourceFile = $faker->file($fakerDir, storage_path('admix/tmp'));
                            $targetFile = Storage::putFile('tmp', new HttpFile($sourceFile));

                            $article->doUploadMultiple($targetFile, $key);
                        }
                    } else {
                        $sourceFile = $faker->file($fakerDir, storage_path('admix/tmp'));
                        $targetFile = Storage::putFile('tmp', new HttpFile($sourceFile));

                        $article->doUpload($targetFile, $key);
                    }
                }

                if (config('admix-articles.downloads')) {
                    $items = $faker->numberBetween(0, 3);
                    for ($i = 0; $i < $items; $i++) {
                        $sourceFile = $faker->file(__DIR__ . '/../Faker/articles/downloads', storage_path('admix/tmp'));
                        $targetFile = Storage::putFile('tmp', new HttpFile($sourceFile));

                        $article->doUploadMultiple($targetFile, 'downloads');
                    }
                }

                $article->save();

                $this->command->getOutput()
                    ->progressAdvance();
            });

        $this->command->getOutput()
            ->progressFinish();
    }
}
