<?php

use Agenciafmd\Articles\Http\Livewire\Pages\Article\Form;
use Agenciafmd\Articles\Http\Livewire\Pages\Article\Index;
use Agenciafmd\Articles\Models\Article;
use Livewire\Livewire;

it('can render index route of articles', function () {
    asAdmix()
        ->get(route('admix.articles.index'))
        ->assertOk();
});

it('can see item on index route of articles', function () {
    $model = create(Article::class);

    asAdmix()
        ->get(route('admix.articles.index'))
        ->assertOk()
        ->assertSee($model->name);
});

it('can render create route of articles', function () {
    asAdmix()
        ->get(route('admix.articles.create'))
        ->assertOk();
});

it('can insert item on create route of articles', function () {
    asAdmix();
    $model = make(Article::class);

    Livewire::test(Form::class)
        ->set('model.is_active', $model->is_active)
        ->set('model.name', $model->name)
        ->call('submit');

    test()->assertDatabaseHas(table(Article::class), [
        'name' => $model->name,
    ]);
});

it('can render and see a item on edit route of articles', function () {
    $model = create(Article::class);

    asAdmix()
        ->get(route('admix.articles.edit', $model))
        ->assertOk()
        ->assertSee($model->name);
});

it('can edit item on edit route of articles', function () {
    asAdmix();
    $model = create(Article::class);

    Livewire::test(Form::class, ['faq' => $model->id])
        ->set('model.name', $model->name . ' - edited')
        ->call('submit');

    test()->assertDatabaseHas(table(Article::class), [
        'name' => $model->name . ' - edited',
    ]);
});

it('can delete item on index route of articles', function () {
    asAdmix();
    $model = create(Article::class);

    Livewire::test(Index::class)
        ->call('bulkDelete', $model->id);

    test()->assertSoftDeleted(table(Article::class), [
        'id' => $model->id,
    ]);
});

it('can render and see a item on trash route of articles', function () {
    $model = create(Article::class);
    $model->delete();

    asAdmix()
        ->get(route('admix.articles.trash'))
        ->assertOk()
        ->assertSee($model->name);
});

it('can restore item on trash route of articles', function () {
    asAdmix();

    $model = create(Article::class);
    $model->delete();

    Livewire::test(Index::class)
        ->set('isTrash', true)
        ->call('bulkRestore', $model->id);

    test()->assertDatabaseHas(table(Article::class), [
        'id' => $model->id,
        'deleted_at' => null,
    ]);
});
