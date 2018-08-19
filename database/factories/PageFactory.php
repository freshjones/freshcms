<?php

use App\Content;
use App\Page;
use Carbon\Carbon;
use Faker\Generator as Faker;


$factory->define(App\Page::class, function (Faker $faker) {

    $title = $faker->unique()->sentence;
    $slug = str_slug($title);

    return [
        'slug' => $slug,
        'display' => 1,
        'publish_at' => null,
        'unpublish_at' =>  null,
    ];
});

// $factory->afterCreating(Page::class, function (Page $page, $faker) {
//     $page->contents()->save( factory('App\Content')->make(['page_id' => $page->id]) );
// });

$factory->state(App\Page::class, 'trashed', function () {
    $now = Carbon::now();
    return [
        'deleted_at' => $now,
        'created_at' =>  $now,
        'updated_at' =>  $now,
    ];
});

$factory->state(App\Page::class, 'scheduled', function () {
    $now = Carbon::now();
    return [
        'publish_at' => $now,
        'unpublish_at' =>  $now,
    ];
});
