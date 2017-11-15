<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\CarUsage;

class DriverController extends Controller
{
    public function index()
    {
        $driver_status  = $this->driverStatus();
        $drivers        = Driver::orderBy('updated_at', 'desc')->paginate(10);
        return view('driver.index', compact('drivers', 'driver_status'));
    }

    public function available()
    {
        $idle_drivers   = Driver::select('id', 'driver_name')
            ->where('status', 0)
            // ->doesntHave('driveOn')
            ->get();

        foreach ($idle_drivers as $id) {
            $id['disabled'] = false;
        }

        return response()
            ->json([
                'model' => $idle_drivers
            ]);
    }

    public function editAvailable($id)
    {
        $cu = CarUsage::findOrFail($id);
        $idle_drivers   = Driver::select('id', 'driver_name')
            ->where('status', 0)
            ->orWhere('id', $cu->driver_id)
            ->orWhere('id', $cu->backup_driver_id)
            // ->doesntHave('driveOn')
            ->get();

        return response()
            ->json([
                'model' => $idle_drivers
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array("meta" => "Create", "entity_id" => null);
        return view('driver.form', compact('data'));
    }

    public function apiCreate()
    {
        $companies = $this->createDistinctApiData('\App\Models\Driver', 'company');
        return response()->json(['model' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate
        $data = $this->validate(request(), [
            'driver_name' => 'required|min:3|string',
            'company_id' => 'required',
            'phonenumber' => 'nullable',
            'status' => 'nullable'
        ]);

        // Store
        $driver = Driver::create($data);

        if ($driver) {
            return response()
                ->json([
                    'message' => "Data driver ({$request->driver_name}) berhasil ditambahkan!",
                    'redirect_url' => '/driver'
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function apiShow($id)
    {
        $driver = Driver::findOrFail($id);
        return response()->json(['model' => $driver]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array("meta" => "Edit", "entity_id" => $id);
        return view('driver.form', compact('data'));
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
        $driver = Driver::findOrFail($id);
        
        // Validate
        $data = $this->validate(request(), [
            'driver_name' => 'required|min:3|string',
            'company_id' => 'required',
            'phonenumber' => 'nullable',
            'status' => 'nullable'
        ]);
        
        // Update
        $driver->fill($data);

        if ($driver->save()) {
            return response()
                ->json([
                    'message' => "Data driver berhasil diupdate!",
                    'redirect_url' => '/driver'
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
        $driver = Driver::findOrFail($id);
        $data = array(
            'message' => "Driver {$driver->driver_name} telah berhasil dihapus!",
            'redirect_url' => "/driver"
        );

        // Relationship
        $dc = \App\Models\DriverCar::where('driver_id', $id)
            ->update(['driver_id' => null]);

        // Destroy
        if ($driver->delete()) {
            return response()
                ->json([
                    'data' => $data
                ]);
        }
    }
}
