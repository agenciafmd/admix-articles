<?php

use Agenciafmd\Articles\Policies\ArticlePolicy;

return [
    [
        'name' => config('admix-articles.name') . ' » ' . config('admix-categories.articles-categories.name'),
        'policy' => '\Agenciafmd\Articles\Policies\CategoryPolicy',
        'abilities' => [
            [
                'name' => 'visualizar',
                'method' => 'view',
            ],
            [
                'name' => 'criar',
                'method' => 'create',
            ],
            [
                'name' => 'atualizar',
                'method' => 'update',
            ],
            [
                'name' => 'deletar',
                'method' => 'delete',
            ],
            [
                'name' => 'restaurar',
                'method' => 'restore',
            ],
        ],
        'sort' => 10,
    ],
    [
        'name' => config('admix-articles.name'),
        'policy' => ArticlePolicy::class,
        'abilities' => [
            [
                'name' => 'View',
                'method' => 'view',
            ],
            [
                'name' => 'Create',
                'method' => 'create',
            ],
            [
                'name' => 'Update',
                'method' => 'update',
            ],
            [
                'name' => 'Delete',
                'method' => 'delete',
            ],
            [
                'name' => 'Restore',
                'method' => 'restore',
            ],
        ],
        'sort' => 120,
    ],
];
