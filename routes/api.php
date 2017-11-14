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
Route::get('user/{id}', 'ManageUsersController@apiShow');

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

Route::get('driver-car/create-available', 'DriverCarController@apiCreate');
Route::get('driver-car/{cpn}/edit-available', 'DriverCarController@apiEdit');

Route::get('fuel/edit/{entity_id}', 'FuelSettingsController@apiEdit');

Route::get('usage/{entity_id}', 'CarUsageController@apiShow');
Route::post('car-usage/finished', 'CarUsageController@historyStore');

// Experiment
Route::get('a', function () {
  $data = \App\Models\DriverCar::with([
    'withDriver' => function ($query) {
        $query->where('status', 0);
    }, 
    'withCar.hasStatus' => function ($query) {
        $query->where('status', 0);
    }])
    ->get();
  return response()->json(['data' => $data]);
});

Route::get('b/{cpn}', function ($cpn) {
  $did = \App\Models\DriverCar::findOrFail($cpn);
  $driver = \App\Models\Driver::findOrFail($did->driver_id);
  return response()->json(['data' => $driver]);
});

Route::post('c', function(Request $request) {
  return response()->json(['model' => $request->all()]);
});

Route::get('d', function() {
  $cm = date('m');
  $cy = date('Y');

  $fuel_month = \App\Models\FuelSetting::where('month', $cm)
      ->where('year', $cy)
      ->get();
  return response()->json(['model' => $fuel_month]);
});

Route::get('e/{month}/{year}', function($month, $year) {
  $fuel = \App\Models\FuelSetting::where('month', $month)
    ->where('year', $year)
    ->get();

  return response()
    ->json([
      'logic' => $fuel->isEmpty(),
      'model' => $fuel
    ]);
});

Route::get('check-driver-availability/{did}', function($did) {
  $driver = \App\Models\Driver::findOrFail($did);

  if ($driver->status > 0) {
    switch ($driver->status) {
      case 1:
        $msg = "Sopir saat ini sedang bertugas";
        break;
      case 2:
        $msg = "Sopir tidak masuk karena izin / sakit";
        break;
      case 3:
        $msg = "Sopir tidak masuk kerja tanpa ada informasi";
        break;
      default:
        $msg = "Sopir saat ini tidak standby";
        break;
    }
    $data = true;
  } else {
    $msg = "";
    $data = false;
  }
  return response()->json([
    'model' => $data,
    'msg' => $msg
  ]);
});
