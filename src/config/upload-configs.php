<?php

return [
    'article' => [
        'image' => [
            'name' => 'Imagem',
            'faker_dir' => false, #database_path('faker/articles/image'),
            'multiple' => false,
            'width' => 800,
            'height' => 600,
            'quality' => 95,
            'optimize' => true,
            'crop' => true,
        ],
    ],
    'articles-categories' => [
        'image' => [
            'name' => 'Imagem',
            'faker_dir' => false, #database_path('faker/articles/image'),
            'multiple' => true,
            'width' => 800,
            'height' => 600,
            'quality' => 95,
            'optimize' => true,
            'crop' => true,
        ],
    ],
];
