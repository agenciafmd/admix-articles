<?php

namespace Agenciafmd\Articles\Livewire\Pages\Article;

use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Ui\Traits\WithMediaSync;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Livewire\Component as LivewireComponent;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithFileUploads;

class Component extends LivewireComponent
{
    use AuthorizesRequests, WithFileUploads, WithMediaSync;

    public Form $form;

    public Article $article;

    public function mount(Article $article): void
    {
        ($article->exists) ? $this->authorize('update', Article::class) : $this->authorize('create', Article::class);

        $this->article = $article;
        $this->form->setModel($article);
    }

    public function submit(): null|Redirector|RedirectResponse
    {
        try {
            if ($this->form->save()) {
                flash(($this->article->exists) ? __('crud.success.save') : __('crud.success.store'), 'success');
            } else {
                flash(__('crud.error.save'), 'error');
            }

            return redirect()->to(session()?->get('backUrl') ?: route('admix.articles.index'));
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            $this->dispatch(event: 'toast', level: 'danger', message: $exception->getMessage());
        }

        return null;
    }

    public function render(): View
    {
        return view('admix-articles::pages.article.form')
            ->extends('admix::internal')
            ->section('internal-content');
    }
}
