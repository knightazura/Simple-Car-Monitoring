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

Route::get('employees', function () {
  $employees = \App\Models\Employee::all();
  $model = array();
  $i = 0;

  foreach ($employees as $employee) {
    $model[$i]['value'] = $employee->employee_name;
    $model[$i]['link'] = $employee->nip;
    $i++;
  }
  return response()->json(['model' => $model]);
});
