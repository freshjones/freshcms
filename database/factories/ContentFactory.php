<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

$factory->define(App\Content::class, function (Faker $faker) {
    return [
        'page_id' => function(){
          return factory('App\Page')->create()->id;
        },
        'lang' => 'en',
        'title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'meta_description' => $faker->sentence,
        'meta_robot' => null,
        'content' => function(){
          $generator = \Faker\Factory::create();
          $content = array();
          $content[] = [
            'id' => Uuid::uuid1()->toString(),
            'type' => 'content',
            'label' => $generator->sentence($nbWords = 3, $variableNbWords = true),
            'order' => 0,
            'display' => 1,
            'style' => 'default',
            'data' => ['description' => implode("\r\n", $generator->paragraphs)],
          ];
          return $content; 
        },
    ];
});
