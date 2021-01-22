<?php

namespace Agenciafmd\Articles\Providers;

use Agenciafmd\Articles\Models\Category;
use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Articles\Policies\CategoryPolicy;
use Agenciafmd\Articles\Policies\ArticlePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Article::class => ArticlePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
