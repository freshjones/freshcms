<?php
/*
* routes for page methods
*/

//Create Form
Route::get('/page/create', 'PageController@create')->name('page-create');
//DB Insert
Route::post('/page', 'PageController@store')->name('page-store');
//Edit Form
Route::get('/page/{slug}/edit', 'PageController@edit')->name('page-edit');
//DB Update
Route::patch('/page/update/{slug}', 'PageController@update')->name('page-update');

//Home Route
Route::get('/', 'PageController@index')->name('home');

//catch all route for pages
Route::get('/{slug}', 'PageController@show')->name('page-show');
