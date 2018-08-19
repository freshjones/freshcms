<?php

use Faker\Generator as Faker;

$factory->define(App\Redirect::class, function (Faker $faker) {
    return [
        'source_url' => function(){
          return factory('App\Content')->create()->page->slug;
        },
        'redirect_url' => str_slug($faker->unique()->sentence),
        'type' => '301',
    ];
});
