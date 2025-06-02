<?php

namespace Agenciafmd\Articles\Livewire\Pages\Article;

use Agenciafmd\Admix\Livewire\Pages\Base\Index as BaseIndex;
use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Categories\Services\CategoryService;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class Index extends BaseIndex
{
    protected $model = Article::class;

    protected string $indexRoute = 'admix.articles.index';

    protected string $trashRoute = 'admix.articles.trash';

    protected string $creteRoute = 'admix.articles.create';

    protected string $editRoute = 'admix.articles.edit';

    public function configure(): void
    {
        $this->packageName = __(config('admix-articles.name'));

        parent::configure();
    }

    public function builder(): Builder
    {
        return $this->model::query()
            ->when(config('admix-articles.category'), function (Builder $builder) {
                $builder->with('categories');
            })
            ->when($this->isTrash, function (Builder $builder) {
                $builder->onlyTrashed();
            })
            ->when(!$this->hasSorts(), function (Builder $builder) {
                $builder->sort();
            });
    }

    public function filters(): array
    {
        if (!config('admix-articles.category')) {
            return parent::filters();
        }

        $this->setAdditionalFilters([
            SelectFilter::make(__('admix-articles::fields.category'), 'category')
                ->options(['' => __('-')] + (new CategoryService)->toSelect(Article::class))
                ->filter(static function (Builder $builder, string $value) {
                    $builder->whereHas('categories', function ($builder) use ($value) {
                        $builder->where($builder->qualifyColumn('model'), Article::class)
                            ->where($builder->qualifyColumn('type'), 'categories')
                            ->where($builder->qualifyColumn('id'), $value);
                    });
                }),
        ]);

        return parent::filters();
    }

    public function columns(): array
    {
        if (!config('admix-articles.category')) {
            return parent::columns();
        }

        $this->setAdditionalColumns([
            Column::make(__('admix-articles::fields.category'))
                ->label(
                    fn($row, Column $column) => $row->categories
                        ->where('type', 'categories')
                        ->first()
                        ?->name
                )
                ->sortable()
                ->searchable(function (Builder $builder, $value) {
                    $builder->orWhereHas('categories', function ($builder) use ($value) {
                        $builder->where($builder->qualifyColumn('name'), 'like', '%' . $value . '%');
                    });
                }),
        ]);

        return parent::columns();
    }
}
