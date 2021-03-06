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

/* trash routes */
require(__DIR__.'/web_routes/trash.php');

/* redirect routes */
require(__DIR__.'/web_routes/redirects.php');


/* page routes */
require(__DIR__.'/web_routes/page_routes.php');



/* dialogflow routes */
require(__DIR__.'/web_routes/dialogflow.php');

