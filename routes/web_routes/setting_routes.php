<?php

//Route::get('/authenticate', 'Auth\AuthenticateController@getAuthentication')->name('authenticate');

//view account dashboard
Route::get('/settings/configuration', 'Settings\ConfigurationController@index')->name('settings-configuration');
Route::post('/settings/configuration', 'Settings\ConfigurationController@store')->name('settings-store');
