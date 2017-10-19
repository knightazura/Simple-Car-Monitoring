<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarStatus;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $car_status = array(
            '0' => 'Tersedia',
            '1' => 'Sedang dipakai',
            '2' => 'Sedang diperbaiki',
            '3' => 'Rusak'
        );
        $cars = Car::with('hasStatus')->paginate(10);
        return view('car.index', compact('cars', 'car_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $meta = "Create";
        return view('car.form', compact('meta'));
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
        $status  = new CarStatus(['status' => 0]);
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
        $meta   = 'Edit';
        $car    = Car::where('plat_number', $id)->get();

        return view('car.form', compact('car', 'meta'));
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

        $car->car_name = $request->car_name;
        $car->plat_number = $request->plat_number;

        // Update
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

        // Destroy entity
        if ($car->delete()) {
            return response()
                ->json([
                    'data' => $data
                ]);
        }
    }
}
