<?php

namespace Agenciafmd\Articles\Observers;

use Agenciafmd\Articles\Models\Article;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ArticleObserver
{
    public function saving(Article $model)
    {
        $model->slug = Str::slug($model->name);
    }

    public function saved(Article $model)
    {
        if (!app()->runningInConsole()) {

            try {
                dispatch(function () use ($model) {
                    Artisan::call('page-cache:clear', [
                        'slug' => 'pc__index__pc',
                    ]);

                    Http::get(url('/'));
                })
                    ->delay(now()->addSeconds(5))
                    ->onQueue('low');
            } catch (\Exception $exception) {
                // não tem problema
            }

            try {
                dispatch(function () use ($model) {
                    $url = str_replace(config('app.url') . '/', '', $model->url);
                    Artisan::call('page-cache:clear', [
                        'slug' => $url,
                    ]);

                    Http::get($model->url);
                })
                    ->delay(now()->addSeconds(5))
                    ->onQueue('low');
            } catch (\Exception $exception) {
                // não tem problema
            }
        }
    }
}