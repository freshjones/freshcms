<?php

use Faker\Generator as Faker;

$factory->define(App\Page::class, function (Faker $faker) {

    $title = $faker->unique()->sentence;
    $slug = str_slug($title);

    return [
        'slug' => $slug,
    ];
});
