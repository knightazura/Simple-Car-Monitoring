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
Route::get('employees/available', 'EmployeeController@available');
Route::get('driver/available', 'DriverController@available');
Route::get('car/available', 'CarController@available');
Route::get('usage/{entity_id}', 'CarUsageController@apiShow');
Route::post('car-usage/finished', 'CarUsageController@historyStore');

Route::post('a', function (Request $request) {
  return response()->json(['data' => $request->all()]);
});


