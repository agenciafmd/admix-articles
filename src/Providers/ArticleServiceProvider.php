<?php

namespace Agenciafmd\Articles\Providers;

use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->providers();

        $this->setMenu();

        $this->loadViews();

        $this->loadMigrations();

        $this->loadTranslations();

        $this->loadViewComposer();

        $this->publish();

        if ($this->app->environment('local') && $this->app->runningInConsole()) {
            $this->setLocalFactories();
        }
    }

    protected function providers()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
    }

    protected function setMenu()
    {
        $this->app->make('admix-menu')
            ->push((object)[
                'view' => config('admix-articles.category') ? 'agenciafmd/articles::partials.menus.category-item' : 'agenciafmd/articles::partials.menus.item',
                'ord' => config('admix-articles.sort', 1),
            ]);
    }

    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'agenciafmd/articles');
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function loadTranslations()
    {
        $this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang');
    }

    protected function loadViewComposer()
    {
        //
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/agenciafmd/articles'),
        ], 'views');
    }

    public function setLocalFactories()
    {
        $this->app->make('Illuminate\Database\Eloquent\Factory')
            ->load(__DIR__ . '/../database/factories');
    }

    public function register()
    {
        $this->loadConfigs();
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
