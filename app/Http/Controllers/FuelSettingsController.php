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
      $fuel_record = FuelSetting::create($data);

      return response()
        ->json([
          'message' => "Jatah Bahan Bakar berhasil diset"
        ]);
    }

    public function update(Request $request, $id)
    {
      $fuel = FuelSetting::findOrFail($id);
      $fuel->fill($request->only(['fuel_ratio', 'month', 'year']));
      $fuel->save();

      return response()
        ->json([
          'message' => "Jatah Bahan Bakar berhasil diubah"
        ]);
    }
}
