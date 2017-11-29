<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\FuelSetting;

class FuelSettingsController extends Controller
{
    public function customIndex($year)
    {
      $selected_year = $year;
      $psv_year = FuelSetting::select('year')->distinct()->get();
      $fuels = FuelSetting::where('year', $year)->get();
      $data['meta'] = 'Index';
      $data['entity_id'] = null;

      return view('fuel-settings.index', compact('data', 'fuels', 'psv_year', 'selected_year'));
    }

    public function edit($id)
    {
      $entity = FuelSetting::findOrFail($id);
      $selected_year = $entity->year;
      $psv_year = FuelSetting::select('year')->distinct()->get();
      $fuels = FuelSetting::where('year', $selected_year)->get();

      $data['meta'] = 'Edit';
      $data['entity_id'] = $id;

      return view('fuel-settings.index', compact('data', 'fuels', 'psv_year', 'selected_year'));
    }

    public function apiCurrentUsageEdit()
    {
      $csd = date('Y-m-d H:i:s', mktime(0,0,0,date('m'),1,date('Y')));
      $ced = date('Y-m-d H:i:s', strtotime('+1 months', strtotime($csd)));

      $fuel_cusage = \App\Models\CarUsage::whereBetween('created_at', [$csd, $ced])
        ->sum('fuel_usage');
      $fuel_husage = \App\Models\HistoryCarUsage::whereBetween('start_use', [$csd, $ced])
          ->sum('fuel_usage');
      $fuel_usage = $fuel_cusage + $fuel_husage;

      return response()
        ->json([
          'model' => $fuel_usage
        ]);
    }

    public function apiEdit($id)
    {
      $data = FuelSetting::findOrFail($id);
      return response()
        ->json([
          'model' => $data
        ]);
    }

    public function store(Request $request)
    {
      $data = $this->validate(($request), [
        'fuel_ratio' => 'required',
        'month' => 'required',
        'year' => 'required'
      ]);

      // Check existence of records
      $fuel = FuelSetting::where('month', $request->month)
        ->where('year', $request->year)
        ->get();

      if ($fuel->isEmpty()) {
        $fuel_record = FuelSetting::create($data);

        return response()
          ->json([
            'icon' => 'success',
            'message' => "Jatah Bahan Bakar berhasil diset",
            'redirect_url' => "/home"
          ]);
      } else {
        return response()
          ->json([
            'icon' => 'warning',
            'message' => "Jatah bahan bakar untuk periode bulan {$request->month} / tahun {$request->year} sudah ada. Silahkan lakukan edit jika ingin mengubahnya",
            'redirect_url' => "/fuel/index/{$request->year}"
          ]);
      }
    }

    public function update(Request $request, $id)
    {
      $fuel = FuelSetting::findOrFail($id);
      $fuel->fill($request->only(['fuel_ratio', 'month', 'year']));
      $fuel->save();

      return response()
        ->json([
          'message' => "Jatah Bahan Bakar berhasil diubah",
          'redirect_url' => "/fuel/index/{$request->year}"
        ]);
    }
}
