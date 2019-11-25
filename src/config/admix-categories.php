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
        'image' => false,
//        'image' => [
//            'faker_dir' => false, #database_path('faker/articles/image'),
//            'width' => 800,
//            'height' => 600,
//            'quality' => 95,
//            'optimize' => true,
//            'crop' => true,
//        ],
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
