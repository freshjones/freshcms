<?php
/*
* routes for billboard screen methods
*/

//DB Insert
Route::get('/billboard_screen/{page}/{section}', 'Content\BillboardScreenController@index')->name('billboard_screen-index');
//DB Store
Route::post('/billboard_screen', 'Content\BillboardScreenController@store')->name('billboard_screen-store');
//DB Sort Order
Route::patch('/billboard_screen/sort/{page}/{section}', 'Content\BillboardScreenController@sort_update')->name('billboard_screen-sort');

