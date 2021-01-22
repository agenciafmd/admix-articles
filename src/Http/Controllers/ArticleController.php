<?php

namespace Agenciafmd\Articles\Http\Controllers;

use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Articles\Http\Requests\ArticleRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        session()->put('backUrl', request()->fullUrl());

        $query = QueryBuilder::for(Article::class)
            ->defaultSorts(config('admix-articles.default_sort'))
            ->allowedSorts($request->sort)
            ->allowedFilters(array_merge((($request->filter) ? array_keys(array_diff_key($request->filter, array_flip(['id', 'is_active']))) : []), [
                AllowedFilter::exact('id'),
                AllowedFilter::exact('is_active'),
            ]));

        if ($request->is('*/trash')) {
            $query->onlyTrashed();
        }

        $view['items'] = $query->paginate($request->get('per_page', 50));

        return view('agenciafmd/articles::index', $view);
    }

    public function create(Article $article)
    {
        $view['model'] = $article;

        return view('agenciafmd/articles::form', $view);
    }

    public function store(ArticleRequest $request)
    {
        if ($article = Article::create($request->validated())) {
            flash('Item inserido com sucesso.', 'success');
        } else {
            flash('Falha no cadastro.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.articles.index');
    }

    public function show(Article $article)
    {
        $view['model'] = $article;

        return view('agenciafmd/articles::form', $view);
    }

    public function edit(Article $article)
    {
        $view['model'] = $article;

        return view('agenciafmd/articles::form', $view);
    }

    public function update(Article $article, ArticleRequest $request)
    {
        if ($article->update($request->validated())) {
            flash('Item atualizado com sucesso.', 'success');
        } else {
            flash('Falha na atualização.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.articles.index');
    }

    public function destroy(Article $article)
    {
        if ($article->delete()) {
            flash('Item removido com sucesso.', 'success');
        } else {
            flash('Falha na remoção.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.articles.index');
    }

    public function restore($id)
    {
        $article = Article::onlyTrashed()
            ->find($id);

        if (!$article) {
            flash('Item já restaurado.', 'danger');
        } elseif ($article->restore()) {
            flash('Item restaurado com sucesso.', 'success');
        } else {
            flash('Falha na restauração.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.articles.index');
    }

    public function batchDestroy(Request $request)
    {
        if (Article::destroy($request->get('id', []))) {
            flash('Item removido com sucesso.', 'success');
        } else {
            flash('Falha na remoção.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.articles.index');
    }

    public function batchRestore(Request $request)
    {
        $article = Article::onlyTrashed()
            ->whereIn('id', $request->get('id', []))
            ->restore();

        if ($article) {
            flash('Item restaurado com sucesso.', 'success');
        } else {
            flash('Falha na restauração.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admix.articles.index');
    }
}
