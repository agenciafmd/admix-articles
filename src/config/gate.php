<?php

return [
    [
        'name' => 'Artigos » Categorias',
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
                'name' => 'restarurar',
                'method' => 'restore',
            ],
        ],
        'sort' => 9,
    ],
    [
        'name' => 'Artigos',
        'policy' => '\Agenciafmd\Articles\Policies\ArticlePolicy',
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
                'name' => 'restarurar',
                'method' => 'restore',
            ],
        ],
        'sort' => 10,
    ],
];
