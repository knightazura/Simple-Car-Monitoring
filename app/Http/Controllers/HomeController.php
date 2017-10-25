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
        $total_avail_cars = CarStatus::where('status', 0)
            ->doesntHave('usage')
            ->count();
        $total_idle_drivers = Driver::where('status', 0)
            ->doesntHave('driveOn')
            ->count();

        $highlights_data = array(
            'tac' => $total_avail_cars,
            'tid' => $total_idle_drivers
        );

        // Car Usages
        $car_usages = CarUsage::paginate(3);

        return view('home-2', compact('car_usages', 'highlights_data', 'meta', 'id'));
    }
}
