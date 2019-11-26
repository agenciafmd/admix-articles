<?php

return [
    'articles-categories' => [
        'name' => 'Categorias',
        'icon' => 'icon fe-minus',
        'description' => false,
        'sort' => 20,
        'default_sort' => [
            '-is_active',
            'sort',
            'name',
        ],
        'items' => false,
//        'items' => [
//            'Datas Comemorativas',
//            'Estudo de Vendas',
//            'Eventos',
//            'Vídeos',
//            'Web',
//        ]
    ],
];
