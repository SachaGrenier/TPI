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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/workers', function () {
    return view('workers');
});

Route::get('/getworkersarray', ['uses' =>'WorkersController@getWorkersArray']);

Route::post('/deleteworker', ['uses' =>'WorkersController@deleteWorker']);

Route::post('addworker',['uses' => 'WorkersController@addWorker']);