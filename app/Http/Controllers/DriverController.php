<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = Driver::orderBy('updated_at', 'desc')->paginate(10);
        return view('driver.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $meta = "Create";
        return view('driver.form', compact('meta'));
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
            'company' => 'nullable'
        ]);

        // Store
        $driver = Driver::create($data);

        if ($driver) return redirect()->route('driver.index')->with('success', "Data driver ({$request->driver_name}) berhasil ditambahkan!");
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
        $meta   = "Edit";
        $driver = Driver::findOrFail($id);
        return view('driver.form', compact('meta', 'driver'));
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
            'driver_name' => 'required|min:3|string'
        ]);

        // Update
        $driver->fill($data);
        if ($driver->save()) return redirect()->route('driver.index')->with('success', "Data driver berhasil diupdate!");
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

        // Destroy
        if ($driver->delete()) {
            return response()
                ->json([
                    'data' => $data
                ]);
        }
    }
}
