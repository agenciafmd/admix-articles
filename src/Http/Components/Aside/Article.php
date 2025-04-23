<?php

namespace Agenciafmd\Articles\Http\Components\Aside;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Gate;
use Agenciafmd\Articles\Models\Article as ArticleModel;

class Article extends Component
{
    public function __construct(
        public string $icon = '',
        public string $label = '',
        public string $url = '',
        public bool $active = false,
        public bool $visible = false,
    ) {}

    public function render(): View
    {
        $this->icon = __(config('admix-articles.icon'));
        $this->label = __(config('admix-articles.name'));
        $this->url = route('admix.articles.index');
        $this->active = request()?->currentRouteNameStartsWith('admix.articles');
        $this->visible = Gate::allows('view', ArticleModel::class);

        return view('admix::components.aside.item');
    }
}
