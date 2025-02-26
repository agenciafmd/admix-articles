<?php

namespace Agenciafmd\Articles\Providers;

use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->providers();

        $this->loadMigrations();

        $this->loadTranslations();

        $this->publish();
    }

    public function register(): void
    {
        $this->loadConfigs();
    }

    private function providers(): void
    {
        $this->app->register(BladeServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(LivewireServiceProvider::class);
    }

    private function publish(): void
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

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    private function loadTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'admix-articles');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../../lang');
    }

    private function loadConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/admix-articles.php', 'admix-articles');
        $this->mergeConfigFrom(__DIR__ . '/../../config/audit-alias.php', 'audit-alias');
    }
}
