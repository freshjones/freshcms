<?php
/*
* routes for content methods
*/

//Create Form
Route::get('/content/create/{page_id}', 'Content\ContentController@create')->name('content-create');

//Edit Form
Route::get('/content/edit/{page_id}/{key}', 'Content\ContentController@edit')->name('content-edit');

//DB Update
Route::patch('/content/update/{page_id}/{key}', 'Content\ContentController@update')->name('content-update');

//DB Delete
Route::delete('/content/destroy/{page_id}/{key}', 'Content\ContentController@destroy')->name('content-destroy');

//Content Revert
Route::get('/content/{content}/{revision}/revert', 'Content\ContentRevertController')->name('content-revert');

