<?php
/*
* routes for redirects methods
*/
Route::prefix('admin')->group(function () {

    Route::get('/trash', 'Trash\TrashController@index')->name('trash.index');
    Route::get('/trash/restore/{trashed_page}', 'Trash\TrashRestoreController')->name('trash.restore');
    Route::get('/trash/{trashed_page}', 'Trash\TrashDestroyController')->name('trash.destroy');

    // Route::get('/redirects/create', 'RedirectController@create')->name('redirects-create');
    // Route::post('/redirects/store', 'RedirectController@store')->name('redirects-store');
    // Route::patch('/redirects/update/{redirect}', 'RedirectController@update')->name('redirects-update');
    // Route::delete('/redirects/{redirect}', 'RedirectController@destroy')->name('redirects-destroy');

});
