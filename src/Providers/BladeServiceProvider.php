<?php

namespace Agenciafmd\Articles\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadBladeComponents();

        $this->loadBladeDirectives();

        $this->loadBladeComposers();

        $this->bootMenu();

        $this->bootViews();

        $this->bootPublish();
    }

    public function register(): void
    {
        //
    }

    private function loadBladeComponents(): void
    {
        Blade::componentNamespace('Agenciafmd\\Articles\\Http\\Components', 'admix-articles');
    }

    private function loadBladeComposers(): void
    {
        //
    }

    private function loadBladeDirectives(): void
    {
        //
    }

    private function bootMenu(): void
    {
        $this->app->make('admix-menu')
            ->push((object) [
                'component' => 'admix-articles::aside.article',
                'ord' => config('admix-articles.sort'),
            ]);
    }

    private function bootViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'admix-articles');
    }

    private function bootPublish(): void
    {
        // $this->publishes([
        //     __DIR__ . '/../resources/views' => base_path('resources/views/vendor/agenciafmd/articles'),
        // ], 'admix-articles:views');
    }
}
