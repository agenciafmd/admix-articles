<?php

namespace Agenciafmd\Articles\Http\Controllers;

use Agenciafmd\Articles\Models\Category;
use Agenciafmd\Articles\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
{
    protected $categoryModel;

    protected $categoryType;

    protected $categorySlug;

    public function __construct()
    {
        $this->categoryModel = request()->segment(2);
        $this->categoryType = request()->segment(3);
        $this->categorySlug = $this->categoryModel . '-' . $this->categoryType;

        view()->share([
            'categoryModel' => $this->categoryModel,
            'categoryType' => $this->categoryType,
            'categorySlug' => $this->categorySlug,
        ]);
    }

    public function index(Request $request)
    {
        session()->put('backUrl', request()->fullUrl());

        $query = QueryBuilder::for(Category::query());
        if (!$request->sort) {
            $query->sort($this->categorySlug);
        }
        $query->defaultSorts(config("admix-categories.{$this->categorySlug}.default_sort"))
            ->allowedSorts($request->sort)
            ->allowedFilters((($request->filter) ? array_keys($request->get('filter')) : []));

        if ($request->is('*/trash')) {
            $query->onlyTrashed();
        }

        $view['items'] = $query->paginate($request->get('per_page', 50));

        return view('agenciafmd/categories::index', $view);
    }

    public function create(Category $category)
    {
        $view['model'] = $category;

        return view('agenciafmd/categories::form', $view);
    }

    public function store(CategoryRequest $request)
    {
        $data = [
            'is_active' => $request->get('is_active'),
            'name' => $request->get('name'),
            'description' => $request->get('description', ''),
            'sort' => $request->sort ?? null,
        ];

        if (Category::create($data)) {
            flash('Item inserido com sucesso.', 'success');
        } else {
            flash('Falha no cadastro.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route("admix.{$this->categoryModel}.{$this->categoryType}.index");
    }

    public function show(Category $category)
    {
        $view['model'] = $category;

        return view('agenciafmd/categories::form', $view);
    }

    public function edit(Category $category)
    {
        $view['model'] = $category;

        return view('agenciafmd/categories::form', $view);
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $data = [
            'is_active' => $request->get('is_active'),
            'name' => $request->get('name'),
            'description' => $request->get('description', ''),
            'sort' => $request->sort ?? null,
        ];

        if ($category->update($data)) {
            flash('Item atualizado com sucesso.', 'success');
        } else {
            flash('Falha na atualização.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route("admix.{$this->categoryModel}.{$this->categoryType}.index");
    }

    public function destroy(Category $category)
    {
        if ($category->delete()) {
            flash('Item removido com sucesso.', 'success');
        } else {
            flash('Falha na remoção.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route("admix.{$this->categoryModel}.{$this->categoryType}.index");
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()
            ->find($id);

        if (!$category) {
            flash('Item já restaurado.', 'danger');
        } elseif ($category->restore()) {
            flash('Item restaurado com sucesso.', 'success');
        } else {
            flash('Falha na restauração.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route("admix.{$this->categoryModel}.{$this->categoryType}.index");
    }

    public function batchDestroy(Request $request)
    {
        if (Category::destroy($request->get('id', []))) {
            flash('Item removido com sucesso.', 'success');
        } else {
            flash('Falha na remoção.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route("admix.{$this->categoryModel}.{$this->categoryType}.index");
    }

    public function batchRestore(Request $request)
    {
        $category = Category::onlyTrashed()
            ->whereIn('id', $request->get('id', []))
            ->restore();

        if ($category) {
            flash('Item restaurado com sucesso.', 'success');
        } else {
            flash('Falha na restauração.', 'danger');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route("admix.{$this->categoryModel}.{$this->categoryType}.index");
    }
}
