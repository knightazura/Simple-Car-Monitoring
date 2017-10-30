<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// App
Route::get('employees-available/create', 'EmployeeController@available');
Route::get('employee-positions&divisions', 'EmployeeController@apiCreate');
Route::get('employees-available/edit/{id}', 'EmployeeController@editAvailable');
Route::get('employee/{nip}', 'EmployeeController@apiShow');

Route::get('driver-company/existing', 'DriverController@apiCreate');
Route::get('driver-available/create', 'DriverController@available');
Route::get('driver-available/edit/{id}', 'DriverController@editAvailable');
Route::get('driver/{id}', 'DriverController@apiShow');

Route::get('car/existing', 'CarController@apiCreate');
Route::get('car-available/create', 'CarController@available');
Route::get('car-available/edit/{id}', 'CarController@editAvailable');
Route::get('car/{plat_number}', 'CarController@apiShow');
Route::get('chart/current-car-status', 'CarController@current_status');

Route::get('usage/{entity_id}', 'CarUsageController@apiShow');
Route::post('car-usage/finished', 'CarUsageController@historyStore');

// Experiment
Route::get('a', function () {
  $data = \App\Models\HistoryCarUsage::paginate(3);
  return response()->json(['data' => $data]);
});
