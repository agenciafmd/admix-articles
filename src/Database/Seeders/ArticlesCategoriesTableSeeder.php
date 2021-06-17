<?php

namespace Agenciafmd\Articles\Database\Seeders;

use Agenciafmd\Articles\Models\Category;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Facades\Storage;

class ArticlesCategoriesTableSeeder extends Seeder
{
    protected int $total = 10;

    public function run()
    {
        Category::withTrashed()
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

        $faker = Factory::create('pt_BR');

        Category::factory($this->total)
            ->create()
            ->each(function ($category) use ($faker) {

                foreach (config('upload-configs.articles-categories') as $key => $image) {
                    $fakerDir = __DIR__ . '/../Faker/articles-categories/' . $key;

                    if ($image['faker_dir']) {
                        $fakerDir = $image['faker_dir'];
                    }

                    if ($image['multiple']) {
                        $items = $faker->numberBetween(0, 6);
                        for ($i = 0; $i < $items; $i++) {
                            $sourceFile = $faker->file($fakerDir, storage_path('admix/tmp'));
                            $targetFile = Storage::putFile('tmp', new HttpFile($sourceFile));

                            $category->doUploadMultiple($targetFile, $key);
                        }
                    } else {
                        $sourceFile = $faker->file($fakerDir, storage_path('admix/tmp'));
                        $targetFile = Storage::putFile('tmp', new HttpFile($sourceFile));

                        $category->doUpload($targetFile, $key);
                    }
                }

                $category->save();

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
                'is_active' => 1,
                'name' => $item,
            ]);

            $this->command->getOutput()
                ->progressAdvance();
        });

        $this->command->getOutput()
            ->progressFinish();
    }
}