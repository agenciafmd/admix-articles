<?php

return [
    'name' => 'Articles',
    'icon' => 'template',
    'sort' => 120,
    'category' => false,
    'author' => true,
    'call' => false,
    'short_description' => true,
    'video' => false,
    'published_at' => true,
    'image' => [
        'max' => 2048,
        'max_width' => 3840,
        'max_height' => 2160,
        'crop_config' => [
            //            'aspectRatio' => round(3840 / 2160, 2),
        ],
        'show_meta' => false,
    ],
    'gallery' => [
        //
    ],
];
