<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

/*
Route::namespace('Admin')->group(function () {
    Route::get('/admin', 'AdminController@index')->name('admin');
});
*/

Route::get('/', 'HomeController@index')->name('home');


//show all sections for a page
Route::get('/section/{page_id}', 'SectionController@index')->name('section-index');
//form for creating a page section
Route::get('/section/create/{page}/{sectionType}', 'SectionController@create')->name('section-create');
//DB Insert
Route::post('/section', 'SectionController@store')->name('section-store');
//Edit Form
Route::get('/section/{page}/{id}/{type}/edit', 'SectionController@edit')->name('section-edit');
//DB Update
Route::patch('/section/update/{page}/{id}', 'SectionController@update')->name('section-update');
//DB Delete
Route::delete('/section/destroy/{page}/{id}/{type}', 'SectionController@destroy')->name('section-destroy');
//DB Sort Order
Route::patch('/sections/sort/{page}', 'SectionController@sort_update')->name('sort-update');


//DB Insert
Route::get('/billboard/{page}/{section}', 'BillboardController@index')->name('billboard-index');
//DB Insert
Route::post('/billboard', 'BillboardController@store')->name('billboard-store');
//DB Update
Route::patch('/billboard', 'BillboardController@update')->name('billboard-update');
//DB Sort Order
Route::patch('/billboard/sort/{page}/{section}', 'BillboardController@sort_update')->name('billboard-sort');


//view a page
Route::get('/{slug}', 'PageController@show')->name('page-show');
//Create Form
Route::get('/page/create', 'PageController@create')->name('page-create');
//DB Insert
Route::post('/page', 'PageController@store')->name('page-store');
//Edit Form
Route::get('/page/{slug}/edit', 'PageController@edit')->name('page-edit');
//DB Update
Route::patch('/page/update/{slug}', 'PageController@update')->name('page-update');


/*
Route::group(['domain' => '{account}.freshcms.local'], function()
{
    Route::get('user/{id}', function($account, $id)
    {
      echo '<pre>';
      print_r($account);
      echo '</pre>';
      die();
    });
});
*/
