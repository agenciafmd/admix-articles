<?php

use Agenciafmd\Articles\Http\Controllers\ArticleController;
use Agenciafmd\Categories\Http\Controllers\CategoryController;
use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Articles\Models\Category;

if (config('admix-articles.category')) {
    Route::get('articles/categories', [CategoryController::class, 'index'])
        ->name('admix.articles.categories.index')
        ->middleware('can:view,' . Category::class);
    Route::get('articles/categories/trash', [CategoryController::class, 'index'])
        ->name('admix.articles.categories.trash')
        ->middleware('can:restore,' . Category::class);
    Route::get('articles/categories/create', [CategoryController::class, 'create'])
        ->name('admix.articles.categories.create')
        ->middleware('can:create,' . Category::class);
    Route::post('articles/categories', [CategoryController::class, 'store'])
        ->name('admix.articles.categories.store')
        ->middleware('can:create,' . Category::class);
    Route::get('articles/categories/{category}', [CategoryController::class, 'show'])
        ->name('admix.articles.categories.show')
        ->middleware('can:view,' . Category::class);
    Route::get('articles/categories/{category}/edit', [CategoryController::class, 'edit'])
        ->name('admix.articles.categories.edit')
        ->middleware('can:update,' . Category::class);
    Route::put('articles/categories/{category}', [CategoryController::class, 'update'])
        ->name('admix.articles.categories.update')
        ->middleware('can:update,' . Category::class);
    Route::delete('articles/categories/destroy/{category}', [CategoryController::class, 'destroy'])
        ->name('admix.articles.categories.destroy')
        ->middleware('can:delete,' . Category::class);
    Route::post('articles/categories/{id}/restore', [CategoryController::class, 'restore'])
        ->name('admix.articles.categories.restore')
        ->middleware('can:restore,' . Category::class);
    Route::post('articles/categories/batchDestroy', [CategoryController::class, 'batchDestroy'])
        ->name('admix.articles.categories.batchDestroy')
        ->middleware('can:delete,' . Category::class);
    Route::post('articles/categories/batchRestore', [CategoryController::class, 'batchRestore'])
        ->name('admix.articles.categories.batchRestore')
        ->middleware('can:restore,' . Category::class);
}

Route::get('articles', [ArticleController::class, 'index'])
    ->name('admix.articles.index')
    ->middleware('can:view,' . Article::class);
Route::get('articles/trash', [ArticleController::class, 'index'])
    ->name('admix.articles.trash')
    ->middleware('can:restore,' . Article::class);
Route::get('articles/create', [ArticleController::class, 'create'])
    ->name('admix.articles.create')
    ->middleware('can:create,' . Article::class);
Route::post('articles', [ArticleController::class, 'store'])
    ->name('admix.articles.store')
    ->middleware('can:create,' . Article::class);
Route::get('articles/{article}/edit', [ArticleController::class, 'edit'])
    ->name('admix.articles.edit')
    ->middleware('can:update,' . Article::class);
Route::put('articles/{article}', [ArticleController::class, 'update'])
    ->name('admix.articles.update')
    ->middleware('can:update,' . Article::class);
Route::delete('articles/destroy/{article}', [ArticleController::class, 'destroy'])
    ->name('admix.articles.destroy')
    ->middleware('can:delete,' . Article::class);
Route::post('articles/{id}/restore', [ArticleController::class, 'restore'])
    ->name('admix.articles.restore')
    ->middleware('can:restore,' . Article::class);
Route::post('articles/batchDestroy', [ArticleController::class, 'batchDestroy'])
    ->name('admix.articles.batchDestroy')
    ->middleware('can:delete,' . Article::class);
Route::post('articles/batchRestore', [ArticleController::class, 'batchRestore'])
    ->name('admix.articles.batchRestore')
    ->middleware('can:restore,' . Article::class);
