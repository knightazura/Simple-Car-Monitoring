<?php

// use PDF;

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
    return view('auth.login');
})->name('welcome');

Auth::routes();

Route::middleware(['auth'])->group(function () {
  // Master data module routes
  Route::resource('employee', 'EmployeeController');
  Route::resource('driver', 'DriverController');
  Route::resource('car', 'CarController');

  // Transaction module routes
  Route::resource('car-usage', 'CarUsageController');
  Route::get('car-usage/history/all', 'CarUsageController@historyIndex')->name('car-usage-history-index');
  Route::get('car-usage/history/{usage_id}', 'CarUsageController@historyShow')->name('car-usage-history-show');
  Route::post('/car-usage/history/filter', 'MiscController@historyFilter')->name('history-filter');
});
Route::get('/home', 'HomeController@index')->name('home');

// Experiment
Route::get('/exp', 'CarController@index')->name('car_exp');
Route::get('/exp/ajax/{id}', function ($id) {
  return response()->json(['data' => $id]);
});
Route::get('/exp/print/{id}', 'MiscController@streamFirstDoc')->name('stream-first-doc');
Route::get('/exp/print-2/{id}', 'MiscController@streamSecondDoc')->name('stream-second-doc');
