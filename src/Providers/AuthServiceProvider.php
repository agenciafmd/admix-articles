<?php

namespace Agenciafmd\Articles\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        '\Agenciafmd\Articles\Category' => '\Agenciafmd\Articles\Policies\CategoryPolicy',
        '\Agenciafmd\Articles\Article' => '\Agenciafmd\Articles\Policies\ArticlePolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
