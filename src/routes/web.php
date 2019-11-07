<?php

/*
|--------------------------------------------------------------------------
| ADMIX Routes
|--------------------------------------------------------------------------
*/

if (config('admix-articles.category')) {
    Route::prefix(config('admix.url') . '/articles/categories')
        ->name('admix.articles.categories.')
        ->middleware(['auth:admix-web'])
        ->group(function () {
            Route::get('', '\Agenciafmd\Categories\Http\Controllers\CategoryController@index')
                ->name('index')
                ->middleware('can:view,\Agenciafmd\Articles\Category');
            Route::get('trash', '\Agenciafmd\Categories\Http\Controllers\CategoryController@index')
                ->name('trash')
                ->middleware('can:restore,\Agenciafmd\Articles\Category');
            Route::get('create', '\Agenciafmd\Categories\Http\Controllers\CategoryController@create')
                ->name('create')
                ->middleware('can:create,\Agenciafmd\Articles\Category');
            Route::post('', '\Agenciafmd\Categories\Http\Controllers\CategoryController@store')
                ->name('store')
                ->middleware('can:create,\Agenciafmd\Articles\Category');
            Route::get('{category}', '\Agenciafmd\Categories\Http\Controllers\CategoryController@show')
                ->name('show')
                ->middleware('can:view,\Agenciafmd\Articles\Category');
            Route::get('{category}/edit', '\Agenciafmd\Categories\Http\Controllers\CategoryController@edit')
                ->name('edit')
                ->middleware('can:update,\Agenciafmd\Articles\Category');
            Route::put('{category}', '\Agenciafmd\Categories\Http\Controllers\CategoryController@update')
                ->name('update')
                ->middleware('can:update,\Agenciafmd\Articles\Category');
            Route::delete('destroy/{category}', '\Agenciafmd\Categories\Http\Controllers\CategoryController@destroy')
                ->name('destroy')
                ->middleware('can:delete,\Agenciafmd\Articles\Category');
            Route::post('{id}/restore', '\Agenciafmd\Categories\Http\Controllers\CategoryController@restore')
                ->name('restore')
                ->middleware('can:restore,\Agenciafmd\Articles\Category');
            Route::post('batchDestroy', '\Agenciafmd\Categories\Http\Controllers\CategoryController@batchDestroy')
                ->name('batchDestroy')
                ->middleware('can:delete,\Agenciafmd\Articles\Category');
            Route::post('batchRestore', '\Agenciafmd\Categories\Http\Controllers\CategoryController@batchRestore')
                ->name('batchRestore')
                ->middleware('can:restore,\Agenciafmd\Articles\Category');
        });
}

Route::prefix(config('admix.url') . '/articles')
    ->name('admix.articles.')
    ->middleware(['auth:admix-web'])
    ->group(function () {
        Route::get('', 'ArticleController@index')
            ->name('index')
            ->middleware('can:view,\Agenciafmd\Articles\Article');
        Route::get('trash', 'ArticleController@index')
            ->name('trash')
            ->middleware('can:restore,\Agenciafmd\Articles\Article');
        Route::get('create', 'ArticleController@create')
            ->name('create')
            ->middleware('can:create,\Agenciafmd\Articles\Article');
        Route::post('', 'ArticleController@store')
            ->name('store')
            ->middleware('can:create,\Agenciafmd\Articles\Article');
        Route::get('{article}', 'ArticleController@show')
            ->name('show')
            ->middleware('can:view,\Agenciafmd\Articles\Article');
        Route::get('{article}/edit', 'ArticleController@edit')
            ->name('edit')
            ->middleware('can:update,\Agenciafmd\Articles\Article');
        Route::put('{article}', 'ArticleController@update')
            ->name('update')
            ->middleware('can:update,\Agenciafmd\Articles\Article');
        Route::delete('destroy/{article}', 'ArticleController@destroy')
            ->name('destroy')
            ->middleware('can:delete,\Agenciafmd\Articles\Article');
        Route::post('{id}/restore', 'ArticleController@restore')
            ->name('restore')
            ->middleware('can:restore,\Agenciafmd\Articles\Article');
        Route::post('batchDestroy', 'ArticleController@batchDestroy')
            ->name('batchDestroy')
            ->middleware('can:delete,\Agenciafmd\Articles\Article');
        Route::post('batchRestore', 'ArticleController@batchRestore')
            ->name('batchRestore')
            ->middleware('can:restore,\Agenciafmd\Articles\Article');
    });
