<?php
/*
* routes for section methods
*/

//show all sections for a page
Route::get('/section/{page_id}', 'Content\SectionController@index')->name('section-index');
//DB Sort Order
Route::patch('/section/sort/{page_id}', 'Content\SectionController@sort')->name('section-sort');
