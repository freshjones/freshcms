<?php
/*
* routes for billboard methods
*/

//Create Form
Route::get('/billboard/create/{page_id}', 'Content\BillboardController@create')->name('billboard-create');
//Edit Form
Route::get('/billboard/edit/{page_id}/{key}', 'Content\BillboardController@edit')->name('billboard-edit');
//DB Update
Route::patch('/billboard/update/{page_id}/{key}', 'Content\BillboardController@update')->name('billboard-update');
//DB Delete
Route::delete('/section/destroy/{page_id}/{key}', 'Content\BillboardController@destroy')->name('billboard-destroy');
