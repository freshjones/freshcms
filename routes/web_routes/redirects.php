<?php
/*
* routes for redirects methods
*/
Route::prefix('admin')->group(function () {

    Route::get('/redirects', 'RedirectController@index')->name('redirects-index');
    Route::get('/redirects/create', 'RedirectController@create')->name('redirects-create');
    Route::post('/redirects/store', 'RedirectController@store')->name('redirects-store');
    Route::get('/redirects/edit/{redirect}', 'RedirectController@edit')->name('redirects-edit');
    Route::patch('/redirects/update/{redirect}', 'RedirectController@update')->name('redirects-update');
    Route::delete('/redirects/{redirect}', 'RedirectController@destroy')->name('redirects-destroy');

});
