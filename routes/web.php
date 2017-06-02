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

Route::get('/', function()
{
	return redirect('/planning');
});

Route::get('planning/{weeknb?}/{year?}','PlanningController@index');




Route::get('workers', function () {
    return view('workers');
});


Route::get('workersplanning/{weeknb?}/{year?}','PlanningController@workersplanning');

Route::get('getworkersarray', ['uses' =>'WorkersController@getWorkersArray']);

Route::post('deleteworker', ['uses' =>'WorkersController@deleteWorker']);

Route::post('addworker',['uses' => 'WorkersController@addWorker']);

Route::post('addmsp', 'MSPController@addMSP');

Route::post('deletemsp', 'MSPController@deleteMSP');

Route::get('getmenu', ['uses' =>'LevelController@getMenu']);

Route::post('addlevel1',['uses' => 'LevelController@addLevel1']);

Route::post('addlevel2',['uses' => 'LevelController@addLevel2']);

Route::post('addlevel3',['uses' => 'LevelController@addLevel3']);

Route::post('remlevel3',['uses' => 'LevelController@remLevel3']);

Route::post('remlevel2',['uses' => 'LevelController@remLevel2']);

Route::post('remlevel1',['uses' => 'LevelController@remLevel1']);

Route::get('getworkers', ['uses' =>'WorkersController@getworkers']);

Route::post('addworkeratworkshop', ['uses' => 'PlanningController@AddWorkerAtWorkshop']);

Route::post('remworkeratworkshop', ['uses' => 'PlanningController@RemoveWorkerAtWorkshop']);



Route::get('getplanningcells', ['uses' => 'PlanningController@getPlanningCells']);

Route::post('print',['uses' => 'PDFController@toPDF']);





