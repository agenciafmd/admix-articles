<?php

namespace Agenciafmd\Articles\Observers;

use Agenciafmd\Articles\Models\Category;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class CategoryObserver
{
    public function saved(Category $model)
    {
        if (!app()->runningInConsole()) {

            // mexeu na categoria, é melhor apagar tudo e esperar o cache vir novamente

            try {
                dispatch(function () use ($model) {
                    Artisan::call('page-cache:clear');

                    Http::get(url('/'));
                })
                    ->delay(now()->addSeconds(5))
                    ->onQueue('low');
            } catch (\Exception $exception) {
                // não tem problema
            }
        }
    }
}