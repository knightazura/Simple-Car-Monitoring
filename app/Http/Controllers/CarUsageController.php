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
        $car_usages = CarUsage::orderBy('updated_at', 'desc')->paginate(20);
        return view('car-usage.index', compact('car_usages'));
    }

    public function historyIndex()
    {
        $car_usages = HistoryCarUsage::orderBy('created_at', 'desc')->paginate(50);
        return view('car-usage.history', compact('car_usages'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $meta = 'IndexCreate';
        $id = null;
        return view('car-usage.form', compact('meta', 'id'));
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
                    'message' => 'Berhasil membuat permohonan',
                    'redirect_url' => '/'
                ]);
        }
    }

    // Recap into history
    public function historyStore(Request $request)
    {
        $history = new HistoryCarUsage($request->except(['id', 'created_at', 'updated_at']));

        $history->usage_id = $request->id;
        $history->original_created_date = $request->created_at;
        $history->original_updated_date = $request->updated_at;

        if ($history->save()) {
            // Remove the entity on current usage
            $current_usage = CarUsage::findOrFail($request->id);
            $current_usage->delete();

            return response()
                ->json([
                    'message' => 'Pemakaian kendaraan telah selesai!',
                    'redirect_url' => '/car-usage'
                ]);
        }
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
        // Init
        $usage = CarUsage::findOrFail($id);

        // Modify
        $usage->employee_nip      = $usage->nip;
        $usage->employee          = $usage->requestedBy->employee_name;
        $usage->employee_position = $usage->requestedBy->employee_position;
        $usage->employee_division = $usage->requestedBy->division;
        $usage->driver            = $usage->drivenBy->driver_name;
        $usage->car               = $usage->car_plat_number . " (".$usage->carStatus->theCar->car_name.")";

        // Unset the old properties
        unset($usage->nip);
        unset($usage->driver_id);
        unset($usage->car_plat_number);

        return response()
            ->json([
                'model' => $usage->makeHidden(['requestedBy', 'drivenBy', 'carStatus'])->toArray()
            ]);
    }

    public function historyShow($id)
    {
        $usage = HistoryCarUsage::where('usage_id', $id)->get();
        $usage = $usage[0];
        return view('car-usage.history-show', compact('usage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $meta = 'Edit';
        return view('car-usage.form', compact('meta', 'id'));
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
        // Init
        $usage = CarUsage::findOrFail($id);
        $usage->fill($request->all());

        // Update
        if ($usage->save()) {
            return response()
                ->json([
                    'message' => 'Data permohonan / pemakaian kendaraan berhasil diupdate!',
                    'redirect_url' => '/car-usage'
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
        $usage = CarUsage::findOrFail($id);
        $data = array(
            'message' => "Data permohonan / pemakaian kendaraan berhasil dihapus!",
            'redirect_url' => "/car-usage"
        );

        // Destroy
        if ($usage->delete()) {
            return response()
                ->json([
                    'data' => $data
                ]);
        }
    }
}
