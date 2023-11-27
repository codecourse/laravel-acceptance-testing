<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => '/groups'], function () {
    Route::post('/', 'GroupController@store')->name('groups.store');
    Route::get('/{group}', 'GroupController@show')->name('groups.show');

    Route::group(['prefix' => '/{group}/tasks'], function () {
        Route::post('/', 'TaskController@store')->name('tasks.store');
        Route::delete('/{task}', 'TaskController@destroy')->name('tasks.destroy');
        Route::get('/{task}/edit', 'TaskController@edit')->name('tasks.edit');
        Route::patch('/{task}', 'TaskController@update')->name('tasks.update');
        Route::patch('/{task}/toggle', 'TaskController@toggle')->name('tasks.toggle');
    });
});
