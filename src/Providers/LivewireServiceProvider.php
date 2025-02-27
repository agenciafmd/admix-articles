<?php

namespace Agenciafmd\Articles\Providers;

use Agenciafmd\Articles\Livewire\Pages;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::component('agenciafmd.articles.livewire.pages.article.index', Pages\Article\Index::class);
        Livewire::component('agenciafmd.articles.livewire.pages.article.component', Pages\Article\Component::class);
    }

    public function register(): void
    {
        //
    }
}
