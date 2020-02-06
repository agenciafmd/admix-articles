<?php

return [
    'name' => 'Artigos',
    'icon' => 'icon fe-book',
    'sort' => 20,
    'default_sort' => [
        '-is_active',
        '-star',
        '-published_at',
        'name',
    ],
    'wysiwyg' => true,
    'category' => false,
    'call' => false,
    'short_description' => false,
    'video' => false,
    'published_at' => false,
    'download' => false,
];
