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
    /*
    $fixture = '{"responseId":"832f3a5a-1ee4-4ed8-9367-dbe1d95b152e","queryResult":{"queryText":"yes","parameters":[],"allRequiredParamsPresent":true,"fulfillmentMessages":[{"text":{"text":[null]}}],"intent":{"name":"projects\/ymcademo-v2\/agent\/intents\/e881bba8-6dbf-4f0a-a6b7-ae03ec30e619","displayName":"Ask-findclass"},"intentDetectionConfidence":1,"languageCode":"en"},"originalDetectIntentRequest":{"payload":[]},"session":"projects\/ymcademo-v2\/agent\/sessions\/53e7d232-2883-7967-0e64-44c41f5d1faf"}';

    $data = json_decode($fixture);


    $file = __DIR__ . '/../demo.txt';

    file_put_contents($file, json_encode($request->all()) );

    */

    $intent = $request->queryResult->intent->displayName;
    $session = $request->session;

    return [
        'fulfillmentText'=>"Your intent is {$intent} your session is {$session}.",
    ];
   
});


