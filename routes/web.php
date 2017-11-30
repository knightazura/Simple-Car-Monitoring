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
  
  // Route::middleware('can:view,post,update,delete')->group(function () {
    // Master data module routes
    Route::resource('employee', 'EmployeeController');
    Route::post('employee/insert-batch', 'EmployeeController@insertBatch')->name('employee.batch');
    Route::get('employee/download/batch-upload-template', 'EmployeeController@downloadTemplateBatch')->name('download-ebt');
    Route::resource('driver', 'DriverController');
    Route::resource('car', 'CarController');
    Route::resource('driver-car', 'DriverCarController');
    Route::resource('driver-company', 'DriverCompanyController');
    Route::resource('fuel', 'FuelSettingsController');
    Route::get('fuel/index/{cy}', 'FuelSettingsController@customIndex')->name('fuel-custom-index');

    // Manage Users
    Route::resource('manage-users', 'ManageUsersController');

    // Misc things like database backup & restore
    Route::get('/misc', 'MiscController@index')->name('misc.index');
    Route::post('/misc/artisan/snapshot-backup/{command}', 'MiscController@snapshotsBackup')->name('misc.snapshot-backup');
    Route::post('/misc/artisan/snapshot-restore', 'MiscController@snapshotRestore')->name('misc.snapshot-restore');

    // Report routes
    Route::get('/report', 'ReportController@index')->name('report-home');
  // });

  // Transaction module RouteServiceProvider
  Route::resource('car-usage', 'CarUsageController');
  Route::get('car-usage/history/all', 'CarUsageController@historyIndex')->name('car-usage-history-index');
  Route::get('car-usage/history/{usage_id}', 'CarUsageController@historyShow')->name('car-usage-history-show');
  Route::post('/car-usage/history/filter', 'MiscController@historyFilter')->name('history-filter');
  Route::delete('/car-usage/history/delete/{id}', 'CarUsageController@historyDestroy')->name('history-delete');
});
Route::get('/home', 'HomeController@index')->name('home');

// Experiment
Route::get('/backup-trial', function () {
  try {
    \Artisan::call('snapshot:create');
    dd("Hurray");
  } catch (Exception $e) {
    dd($e->getMessage());
  }
});
Route::get('/exp', 'CarController@index')->name('car_exp');
Route::get('/exp/ajax/{id}', function ($id) {
  return response()->json(['data' => $id]);
});
Route::get('/exp/print/{id}', 'MiscController@streamFirstDoc')->name('stream-first-doc'); // Form C
Route::get('/exp/print-2/{id}', 'MiscController@streamSecondDoc')->name('stream-second-doc'); // Surat Perjalanan
Route::get('/exp/print-3/{id}', 'MiscController@streamThirdDoc')->name('stream-third-doc'); // Form SPPD
Route::post('/exp/excel-1', 'MiscController@excelFristReport')->name('excel-first-report');
