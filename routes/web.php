<?php

Auth::routes();

/* setting routes */
require(__DIR__.'/web_routes/setting_routes.php');

/* section routes */
require(__DIR__.'/web_routes/section_routes.php');

/* content routes */
require(__DIR__.'/web_routes/content_routes.php');

/* billboard routes */
require(__DIR__.'/web_routes/billboard_routes.php');
require(__DIR__.'/web_routes/billboard_screen_routes.php');

/* page routes */
require(__DIR__.'/web_routes/page_routes.php');

Route::post('/dialogflow/demo', function(\Illuminate\Http\Request $request){

    $file = __DIR__ . '/../demo.txt';

    file_put_contents($file, print_r($request->all(),true) );

    return [
        'fulfillmentText'=>'HEY BEAUTY EH?'
    ];

});


