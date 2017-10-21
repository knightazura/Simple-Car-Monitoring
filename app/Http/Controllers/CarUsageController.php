<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarUsage;
use App\Models\HistoryCarUsage;

class CarUsageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $car_usages = CarUsage::paginate(20);
        return view('car-usage.index', compact('car_usages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $data = $request->validate([
            'nip' => 'required',
            'car_plat_number' => 'required',
            'driver_id' => 'required',
            'destination' => 'required',
            'total_passengers' => 'nullable',
            'necessity' => 'nullable',
            'desire_time' => 'nullable',
            'estimates_time' => 'nullable',
            'additional_description' => 'nullable'
        ]);

        $usage = CarUsage::create($data);

        if ($usage) {
            return response()
                ->json([
                    'request' => $request->all(),
                    'redirect_url' => '/'
                ]);
        }
    }

        public function history_store(Request $request)
        {
            $history = new HistoryCarUsage();
            $history = $request->except(['id', 'created_at', 'updated_at']);

            $history->usage_id = $request->id;
            $history->original_created_at = $request->created_at;
            $history->original_updated_at = $request->updated_at;

            return response()
                ->json([
                    'model' => $history
                ]);
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usage = CarUsage::findOrFail($id);
        return view('car-usage.show', compact('usage'));
    }

        public function apiShow($id)
        {
            $usage = CarUsage::findOrFail($id);

            return response()
                ->json([
                    'model' => $usage
                ]);
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
