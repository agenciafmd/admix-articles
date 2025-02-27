<?php

namespace Agenciafmd\Articles\Livewire\Pages\Article;

use Agenciafmd\Admix\Livewire\Pages\Base\Index as BaseIndex;
use Agenciafmd\Articles\Models\Article;

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
}
