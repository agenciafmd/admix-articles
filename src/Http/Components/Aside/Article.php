<?php

namespace Agenciafmd\Articles\Http\Components\Aside;

use Agenciafmd\Articles\Models\Article as ArticleModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\Component;

class Article extends Component
{
    public function __construct(
        public string $icon = '',
        public string $label = '',
        public string $url = '',
        public bool $active = false,
        public bool $visible = false,
        public array $children = [],
    ) {}

    public function render(): View
    {
        $this->icon = __(config('admix-articles.icon'));
        $this->label = __(config('admix-articles.name'));
        $this->url = !config('admix-articles.category') ? route('admix.articles.index') : '';
        $this->active = request()?->currentRouteNameStartsWith('admix.articles');
        $this->visible = Gate::allows('view', ArticleModel::class);

        if (config('admix-articles.category')) {
            $model = 'articles';
            $types = collect(config('admix-categories.categories'))
                ->where('slug', $model)->first()['types'];
            $children = collect($types)->map(function ($item) use ($model) {
                return [
                    'label' => __($item['name']),
                    'url' => route('admix.categories.index', [
                        'categoryModel' => $model,
                        'categoryType' => $item['slug'],
                    ]),
                    'active' => request()?->is("*{$model}/{$item['slug']}*"),
                    'visible' => true,
                ];
            })->toArray();

            $this->children = [
                ...$children,
                [
                    'label' => __(config('admix-articles.name')),
                    'url' => route('admix.articles.index'),
                    'active' => request()?->currentRouteNameStartsWith('admix.articles'),
                    'visible' => true,
                ],
            ];
        }

        return view(config('admix-articles.category') ? 'admix::components.aside.dropdown' : 'admix::components.aside.item');
    }
}
