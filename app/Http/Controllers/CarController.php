<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Car;
use App\Models\CarStatus;

class CarController extends Controller
{
    public function __construct()
    {
        $this->car_status = array(
            '0' => array('status' => 'Tersedia', 'class' => 'success'),
            '1' => array('status' => 'Sedang dipakai', 'class' => 'info'),
            '2' => array('status' => 'Sedang diperbaiki', 'class' => 'warning'),
            '3' => array('status' => 'Rusak', 'class' => 'danger')
        );
    }

    public function index()
    {
        $car_status = $this->car_status;
        $cars = Car::with('hasStatus')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('car.index', compact('cars', 'car_status'));
    }

    public function available()
    {
        // Init
        $i = 0;
        $cars = CarStatus::with('theCar')
            ->where('status', 0)
            ->get();

        // Group by Car name
        foreach ($cars as $car) {
            $temp_name[] = $car->theCar->car_name;
        }
        $temp_name = array_unique($temp_name); // Distinct the name

        // Fetch the plat numbers
        foreach ($temp_name as $car_name) {
            $ii = 0;
            $model[$i]['label'] = $car_name;
            foreach ($cars as $car) {
                if ($car->theCar->car_name == $car_name) {
                    $model[$i]['options'][$ii]['value'] = $car->car_plat_number; 
                    $model[$i]['options'][$ii]['label'] = $car->car_plat_number; 
                    $ii++;
                }
            }
            $i++;
        }

        return response()
            ->json([
                'model' => $model
            ]);
    }

    public function editAvailable($id)
    {
        // Init
        $i = 0;
        $cu = \App\Models\CarUsage::findOrFail($id);
        $cars = CarStatus::with('theCar')
            ->where('status', 0)
            ->orWhere('car_plat_number', $cu->car_plat_number)
            ->get();

        // Group by Car name
        foreach ($cars as $car) {
            $temp_name[] = $car->theCar->car_name;
        }
        $temp_name = array_unique($temp_name); // Distinct the name

        // Fetch the plat numbers
        foreach ($temp_name as $car_name) {
            $ii = 0;
            $model[$i]['label'] = $car_name;
            foreach ($cars as $car) {
                if ($car->theCar->car_name == $car_name) {
                    $model[$i]['options'][$ii]['value'] = $car->car_plat_number; 
                    $model[$i]['options'][$ii]['label'] = $car->car_plat_number; 
                    $ii++;
                }
            }
            $i++;
        }

        return response()
            ->json([
                'model' => $model
            ]);
    }

    public function create()
    {
        $data['meta']       = "Create";
        $data['entity_id']  = null;
        return view('car.form', compact('data'));
    }

    public function apiCreate()
    {
        $cars = $this->createDistinctApiData('\App\Models\Car', 'car_name');
        return response()->json(['model' => $cars]);
    }

    public function store(Request $request)
    {
        // Validation
        $data = $this->validate(request(), [
            'plat_number' => 'required|string',
            'car_name' => 'required|string'
        ]);

        // Store
        $car = Car::create($data);

        // Additional action, store to CarStatus table
        $status  = new CarStatus(['status' => $request->car_status]);

        // Additional action, register it to DriverCar pairing table
        $drv_car = new \App\Models\DriverCar(['car_plat_number' => $request->plat_number]);
        
        $new_car = Car::findOrFail($request->plat_number);

        if ($car && $new_car->hasStatus()->save($status) && $new_car->responsibleBy()->save($drv_car)) {
            return response()
                ->json([
                    'message' => 'Mobil baru berhasil dibuat!',
                    'redirect_url' => '/car'
                ]);
        }
    }

    public function apiShow($id)
    {
        $car = Car::with('hasStatus:car_plat_number,status')->findOrFail($id);
        $car->car_status = $car->hasStatus->status;
        
        return response()->json(['model' => $car]);
    }

    public function edit($id)
    {
        $data['meta']       = "Edit";
        $data['entity_id']  = $id;
        return view('car.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        $car->fill($request->except(['car_status', 'has_status']));

        // Update (child first)
        $car_status = CarStatus::findOrFail($id);
        $car_status->update([
            'car_plat_number' => $request->plat_number,
            'status' => $request->car_status
        ]);
        if ($car->save()) {
            return response()
                ->json([
                    'message' => 'Data mobil berhasil diupdate!',
                    'redirect_url' => '/car'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Init
        $car = Car::findOrFail($id);
        $data = array(
            'message' => "Mobil {$car->car_name} - {$car->plat_number} telah berhasil dihapus!",
            'redirect_url' => "/car"
        );

        // Destroy entity (and its relationships)
        if ($car->delete()) {
            return response()
                ->json([
                    'data' => $data
                ]);
        }
    }

    public function current_status()
    {
        $current_status = DB::table('car_statuses')
            ->select(DB::raw('count(status) as total_status'))
            ->groupBy('status')
            ->get();
        foreach ($current_status as $key => $value) {
            $model[] = $value->total_status;
        }

        return response()
            ->json([
                'model' => $model
            ]);
    }
}
