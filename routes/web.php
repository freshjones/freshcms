<?php

Auth::routes();

/* setting routes */
require_once(__DIR__.'/web_routes/setting_routes.php');

/* section routes */
require_once(__DIR__.'/web_routes/section_routes.php');

/* content routes */
require_once(__DIR__.'/web_routes/content_routes.php');

/* billboard routes */
require_once(__DIR__.'/web_routes/billboard_routes.php');
require_once(__DIR__.'/web_routes/billboard_screen_routes.php');

/* page routes */
require_once(__DIR__.'/web_routes/page_routes.php');






