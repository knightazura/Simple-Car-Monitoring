<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DriverCar;
use App\Models\Driver;
use App\Models\Car;

class DriverCarController extends Controller
{
    public function index()
    {
      $driver_car = DriverCar::orderBy('updated_at', 'desc')->paginate(10);
      return view('driver-car.index', compact('driver_car'));
    }

    public function create()
    {
      $data['meta']      = 'Create';
      $data['entity_id'] = null;
      return view('driver-car.form', compact('data'));
    }

    public function apiCreate()
    {
      $data['drivers']  = Driver::select('id', 'driver_name', 'company')
        ->doesntHave('responsibleTo')
        ->get();
      $data['cars']     = Car::select('plat_number', 'car_name')
        ->doesntHave('responsibleBy')
        ->get();
      $data['form']     = array();

      return response()
        ->json([
          'model' => $data
        ]);
    }

    public function edit($car_plat_number) {
      $data['meta'] = 'Edit';
      $data['entity_id'] = $car_plat_number;
      return view('driver-car.form', compact('data'));
    }

    public function apiEdit($car_plat_number)
    {
      $dc = DriverCar::where('car_plat_number', $car_plat_number)->get();
      $data['drivers'] = Driver::select('id', 'driver_name', 'company')
        ->doesntHave('driveOn')
        ->get();
      $data['cars']    = Car::select('plat_number', 'car_name')
        ->get();
      $data['form']    = $dc[0];

      return response()
        ->json([
          'model' => $data
        ]);
    }

    public function store(Request $request)
    {
      $data = $this->validate(request(), [
        'car_plat_number' => 'required',
        'driver_id' => 'required'
      ]);

      $driver_car = DriverCar::create($data);
      if ($driver_car) {
        return response()
          ->json([
            'message' => 'Data Sopir dan mobil berhasil di-set!',
            'redirect_url' => '/driver-car'
          ]);
      }
    }

    public function update(Request $request, $car_plat_number)
    {
      // Check driver first, if it overwrite the other entity, then remove it
      $driver_check = DriverCar::where('driver_id', $request->driver_id)->get();

      $data = $this->validate(request(), [
          'car_plat_number' => 'required',
          'driver_id' => 'required'
        ]);

      if ($driver_check->isNotEmpty()) {
        // If not, remove the old driver's relation first and then store it to new car / pair
        $remove_old = DriverCar::where('driver_id', $request->driver_id)
          ->update(['driver_id' => null]);
      }
      $update = DriverCar::where('car_plat_number', $car_plat_number)
        ->update($data);

      if ($update) {
        return response()
          ->json([
            'message' => 'Data berhasil diupdate!',
            'redirect_url' => '/driver-car'
          ]);
      }
    }
}
