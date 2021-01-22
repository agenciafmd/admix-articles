<?php

return [
    'Agenciafmd\Articles\Models\Article' => config('admix-articles.category') ? config('admix-articles.name') . ' » ' . config('admix-articles.name') : config('admix-articles.name'),
    'Agenciafmd\Articles\Models\Category' => config('admix-articles.category') ? config('admix-articles.name') . ' » ' . config('admix-categories.articles-categories.name') : config('admix-categories.articles-categories.name'),
];
