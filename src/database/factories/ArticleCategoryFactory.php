<?php

use Agenciafmd\Articles\Category;

$factory->define(Category::class, function (\Faker\Generator $faker) {

    return [
        'is_active' => $faker->optional(0.3, 1)
            ->randomElement([0]),
        'name' => $faker->sentence(),
    ];
});
