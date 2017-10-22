<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarStatus;

class CarController extends Controller
{
    public function __construct()
    {
        $this->car_status = array(
            '0' => 'Tersedia',
            '1' => 'Sedang dipakai',
            '2' => 'Sedang diperbaiki',
            '3' => 'Rusak'
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $car_status = $this->car_status;
        $cars = Car::with('hasStatus')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        return view('car.index', compact('cars', 'car_status'));
    }

        /**
         *  API feeds, show available cars to used
         *
         *  @return \Illuminate\Http\Response
         */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $car_status = $this->car_status;
        $meta       = "Create";

        return view('car.form', compact('meta', 'car_status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $new_car = Car::findOrFail($request->plat_number);
        $new_car->hasStatus()->save($status);

        return redirect()->route('car.index')->with('success', 'Mobil baru berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car_status = $this->car_status;
        $meta       = 'Edit';
        $car        = Car::findOrFail($id);

        return view('car.form', compact('meta', 'car', 'car_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        $car->fill($request->except(['car_status']));

        // Update (child first)
        $car_status = CarStatus::findOrFail($id);
        $car_status->update([
            'car_plat_number' => $request->plat_number,
            'status' => $request->car_status
        ]);
        $car->save();

        return redirect()->route('car.index')->with('success', 'Data mobil berhasil diupdate!');
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
}
