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

    //$session = $request->session;
    //$query = $request->queryResult;
    //$intent = $query['intent'];

    // return [
    //     'fulfillmentText'=>'Your intent was ' . $request->session;
    // ]; 

    $file = __DIR__ . '/../demo.txt';

    file_put_contents($file, var_export($request->all()) );

    return [
        'fulfillmentText'=>'HEY BEAUTY EH?'
    ];
   
});


