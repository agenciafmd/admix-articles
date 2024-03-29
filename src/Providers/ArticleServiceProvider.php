<?php

namespace Agenciafmd\Articles\Providers;

use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Articles\Models\Category;
use Agenciafmd\Articles\Observers\ArticleObserver;
use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->providers();

        $this->setObservers();

        $this->setSearch();

        $this->loadMigrations();

        $this->publish();
    }

    public function register()
    {
        $this->loadConfigs();
    }

    protected function providers()
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(BladeServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    protected function setObservers()
    {
        Article::observe(ArticleObserver::class);
    }

    protected function setSearch()
    {
        $this->app->make('admix-search')
            ->registerModel(Article::class, 'name')
            ->registerModel(Category::class, 'name');
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../config/admix-articles.php' => config_path('admix-articles.php'),
            __DIR__ . '/../config/admix-categories.php' => config_path('admix-categories.php'),
            __DIR__ . '/../config/upload-configs.php' => config_path('upload-configs.php'),
        ], 'admix-articles:configs');


        $factoriesAndSeeders[__DIR__ . '/../Database/Factories/ArticleFactory.php'] = base_path('database/factories/ArticleFactory.php');
        $factoriesAndSeeders[__DIR__ . '/../Database/Seeders/ArticlesTableSeeder.php'] = base_path('database/seeders/ArticlesTableSeeder.php');
        $factoriesAndSeeders[__DIR__ . '/../Database/Faker/articles/image'] = base_path('database/faker/articles/image');

        if (config('admix-articles.downloads')) {
            $factoriesAndSeeders[__DIR__ . '/../Database/Faker/articles/downloads'] = base_path('database/faker/articles/downloads');
        }

        if (config('admix-articles.category')) {
            $factoriesAndSeeders[__DIR__ . '/../Database/Factories/ArticleCategoryFactory.php'] = base_path('database/factories/ArticleCategoryFactory.php');
            $factoriesAndSeeders[__DIR__ . '/../Database/Seeders/ArticlesCategoriesTableSeeder.php'] = base_path('database/seeders/ArticlesCategoriesTableSeeder.php');
        }

        $this->publishes($factoriesAndSeeders, 'admix-articles:seeders');
    }

    protected function loadConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/admix-articles.php', 'admix-articles');
        $this->mergeConfigFrom(__DIR__ . '/../config/admix-categories.php', 'admix-categories');
        $this->mergeConfigFrom(__DIR__ . '/../config/gate.php', 'gate');
        $this->mergeConfigFrom(__DIR__ . '/../config/audit-alias.php', 'audit-alias');
        $this->mergeConfigFrom(__DIR__ . '/../config/upload-configs.php', 'upload-configs');
    }
}
