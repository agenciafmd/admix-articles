<?php

use Agenciafmd\Articles\Livewire\Pages;
use Illuminate\Support\Facades\Route;

Route::get('/articles', Pages\Article\Index::class)
    ->name('admix.articles.index');
Route::get('/articles/trash', Pages\Article\Index::class)
    ->name('admix.articles.trash');
Route::get('/articles/create', Pages\Article\Component::class)
    ->name('admix.articles.create');
Route::get('/articles/{article}/edit', Pages\Article\Component::class)
    ->name('admix.articles.edit');
