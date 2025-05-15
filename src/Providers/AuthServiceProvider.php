<?php

namespace Agenciafmd\Articles\Providers;

use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Articles\Policies\ArticlePolicy;
use Agenciafmd\Articles\Policies\CategoryPolicy;
use Agenciafmd\Categories\Models\Category;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }

    public function register(): void
    {
        $this->registerConfigs();
    }

    public function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/gate.php', 'gate');
    }
}
