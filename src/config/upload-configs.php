<?php

return [
    'article' => [
        'image' => [ //nome do campo
            'label' => 'imagem', //label do campo
            'multiple' => false, //se permite o upload multiplo
            'faker_dir' => false, #database_path('faker/article/image'),
            'sources' => [
                [
                    'conversion' => 'min-width-1366',
                    'media' => '(min-width: 1366px)',
                    'width' => 1024, // 16:9
                    'height' => 576,
                    'optimize' => ((env('APP_ENV') === 'local') || (env('APP_ENV') === 'testing')) ? false : true,
                    'quality' => ((env('APP_ENV') === 'local') || (env('APP_ENV') === 'testing')) ? 75 : 100,
                ],
                [
                    'conversion' => 'min-width-1280',
                    'media' => '(min-width: 1280px)',
                    'width' => 776,
                    'height' => 437,
                    'optimize' => ((env('APP_ENV') === 'local') || (env('APP_ENV') === 'testing')) ? false : true,
                    'quality' => ((env('APP_ENV') === 'local') || (env('APP_ENV') === 'testing')) ? 75 : 100,
                ],
            ],
        ],
    ],
    'articles-categories' => [
//        'image' => [ //nome do campo
//            'label' => 'imagem', //label do campo
//            'multiple' => false, //se permite o upload multiplo
//            'faker_dir' => false, #database_path('faker/articles-categories/image'),
//            'sources' => [
//                [
//                    'conversion' => 'min-width-1366',
//                    'media' => '(min-width: 1366px)',
//                    'width' => 1024, // 16:9
//                    'height' => 576,
//                    'optimize' => ((env('APP_ENV') === 'local') || (env('APP_ENV') === 'testing')) ? false : true,
//                    'quality' => ((env('APP_ENV') === 'local') || (env('APP_ENV') === 'testing')) ? 75 : 100,
//                ],
//                [
//                    'conversion' => 'min-width-1280',
//                    'media' => '(min-width: 1280px)',
//                    'width' => 776,
//                    'height' => 437,
//                    'optimize' => ((env('APP_ENV') === 'local') || (env('APP_ENV') === 'testing')) ? false : true,
//                    'quality' => ((env('APP_ENV') === 'local') || (env('APP_ENV') === 'testing')) ? 75 : 100,
//                ],
//            ],
//        ],
    ],
];
