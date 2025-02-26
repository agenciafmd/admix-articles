<?php

namespace Agenciafmd\Articles\Providers;

use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->bootProviders();

        $this->bootMigrations();

        $this->bootTranslations();

        $this->bootPublish();
    }

    public function register(): void
    {
        $this->registerConfigs();
    }

    private function bootProviders(): void
    {
        $this->app->register(BladeServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(LivewireServiceProvider::class);
    }

    private function bootPublish(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/admix-articles.php' => base_path('config/admix-articles.php'),
            __DIR__ . '/../../config/upload-configs.php' => base_path('config/upload-configs.php'),
        ], 'admix-articles:configs');

        $this->publishes([
            __DIR__ . '/../../database/seeders/ArticleTableSeeder.php' => base_path('database/seeders/ArticleTableSeeder.php'),
        ], 'admix-articles:seeders');

        $this->publishes([
            __DIR__ . '/../../lang/pt_BR' => lang_path('pt_BR'),
        ], ['admix-articles:translations', 'admix-translations']);
    }

    private function bootMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    private function bootTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'admix-articles');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../../lang');
    }

    private function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/admix-articles.php', 'admix-articles');
        $this->mergeConfigFrom(__DIR__ . '/../../config/audit-alias.php', 'audit-alias');
    }
}
