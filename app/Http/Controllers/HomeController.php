<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarStatus;
use App\Models\Driver;
use App\Models\CarUsage;
use App\Models\HistoryCarUsage;
use App\Models\DriverCar;
use App\Models\FuelSetting;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $i = 0;
        $meta = 'Create';
        $id = null;
        $csd = date('Y-m-d H:i:s', mktime(0,0,0,date('m'),1,date('Y')));
        $ced = date('Y-m-d H:i:s', strtotime('+1 months', strtotime($csd)));

        // Highlights data
        $avail_cars = CarStatus::where('status', 0)
            ->doesntHave('usage')
            ->get();

        $used_cars = CarStatus::where('status', 1)
            ->has('usage')
            ->get();

        $fuel_month = FuelSetting::where('month', date('m'))
            ->where('year', date('Y'))
            ->get();
        $fuel_cusage = CarUsage::sum('fuel_usage');
        $fuel_husage = HistoryCarUsage::whereBetween('start_use', [$csd, $ced])
            ->sum('fuel_usage');

        $fuel_status = ($fuel_month->isNotEmpty()) ? $fuel_month[0]->fuel_ratio - ($fuel_cusage + $fuel_husage) : 0;

        $highlights_data = array(
            'ac' => $avail_cars,
            'uc' => $used_cars,
            'fs' => $fuel_status,
            'ds' => $this->driverStatus()
        );

        return view('home-2', compact('highlights_data', 'meta', 'id'));
    }
}
