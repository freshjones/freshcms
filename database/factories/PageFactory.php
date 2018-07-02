<?php

use Faker\Generator as Faker;

$factory->define(App\Page::class, function (Faker $faker) {

    $title = $faker->unique()->sentence;
    $slug = Str::slug($title);

    return [
        'slug' => $slug,
    ];
});
