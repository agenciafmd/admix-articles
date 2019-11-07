<?php

use Agenciafmd\Articles\Article;

$factory->define(Article::class, function (\Faker\Generator $faker) {

    $videos = [
        'https://youtu.be/t7Fsj8NSmJc',
        'https://youtu.be/sxRsOtovv2g',
        'https://youtu.be/RzaT7uijAis',
        'https://youtu.be/lfRcP3SdxMg',
        'https://youtu.be/HsQx02JdZ2Q',
        'https://youtu.be/WauIURFTpEc',
        'https://youtu.be/HziP2v9gfCg',
        'https://youtu.be/Z4Kz50LFiZk',
    ];

    return [
        'is_active' => $faker->optional(0.3, 1)
            ->randomElement([0]),
        'star' => $faker->optional(0.3, 1)
            ->randomElement([0]),
        'category_id' => 0,
        'name' => $faker->sentence(),
        'call' => config('admix-articles.call') ? $faker->sentence() : null,
        'short_description' => config('admix-articles.short_description') ? (config('admix-articles.wysiwyg') ? "<p>{$faker->paragraph}</p>" : $faker->paragraph) : null,
        'description' => config('admix-articles.wysiwyg') ? '<p>' . collect($faker->paragraphs(5, false))->implode('</p><p>') . '</p>' : $faker->paragraphs(5, true),
        'video' => config('admix-articles.video') ? $faker->randomElement($videos) : null,
        'published_at' => config('admix-articles.published_at') ? $faker->dateTimeBetween('-10 days', '10 days')
            ->format('Y-m-d\TH:i') : null,
    ];
});
