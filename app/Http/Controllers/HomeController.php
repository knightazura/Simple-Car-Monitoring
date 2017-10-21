<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarStatus;
use App\Models\Driver;
use App\Models\CarUsage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $i = 0;
        $meta = 'Create';
        $id = null;

        // Highlights data
        $init_highlights_data = CarUsage::select('car_plat_number', 'driver_id')->get();
        foreach ($init_highlights_data as $data) {
            $car_used[$i] = $data->car_plat_number;
            $idle_drivers[$i] = $data->driver_id;
            $i++;
        }
        $total_avail_cars = CarStatus::where('status', 0)
            ->whereNotIn('car_plat_number', $car_used)
            ->count();
        $total_idle_drivers = Driver::whereNotIn('id', $idle_drivers)
            ->count();

        $highlights_data = array(
            'tac' => $total_avail_cars,
            'tid' => $total_idle_drivers
        );

        // Car Usages
        $car_usages = CarUsage::paginate(3);

        return view('home', compact('car_usages', 'highlights_data', 'meta', 'id'));
    }
}
