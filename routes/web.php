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

    return ['status'=>'cool'];

});


