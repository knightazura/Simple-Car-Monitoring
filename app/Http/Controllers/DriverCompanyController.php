<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DriverCompany;
use App\Models\Driver;

class DriverCompanyController extends Controller
{
  public function index()
  {
    $dcs = DriverCompany::paginate(10);
    return view('driver-company.index', compact('dcs'));
  }

  public function apiShowAll()
  {
    $dcs = DriverCompany::all();
    return response()
      ->json([
        'model' => $dcs
      ]);
  }

  public function create()
  {
    $data = array(
      'meta' => 'Create',
      'entity_id' => null
    );
    return view('driver-company.form', compact('data'));
  }

  public function edit($id)
  {
    $data = array(
      'meta' => 'Edit',
      'entity_id' => $id
    );
    return view('driver-company.form', compact('data'));
  }

  public function apiEdit($id)
  {
    $dc = DriverCompany::findOrFail($id);
    return response()->json(['model' => $dc]);
  }

  public function store(Request $request)
  {
    $data = $this->validate(request(), [
      'company_name' => 'required',
      'company_director' => 'required'
    ]);

    // Store
    $driver_company = DriverCompany::create($data);

    if ($driver_company) {
      return response()
        ->json([
          'message' => "Data Perusahaan Vendor Driver ({$request->company_name}) berhasil ditambahkan!",
          'redirect_url' => '/driver-company'
        ]);
    }
  }

  public function update(Request $request, $id)
  {
    $dc = DriverCompany::findOrFail($id);
        
    // Validate
    $data = $this->validate(request(), [
        'company_name' => 'required',
        'company_director' => 'required'
    ]);
    
    // Update
    $dc->fill($data);

    if ($dc->save()) {
      return response()
        ->json([
          'message' => "Data perusahaan berhasil diupdate!",
          'redirect_url' => '/driver-company'
        ]);
    }
  }

  public function destroy($id)
  {
    // Init
    $dc = DriverCompany::findOrFail($id);
    $data = array(
      'message' => "Perusahaan {$dc->company_name} telah berhasil dihapus!",
      'redirect_url' => "/driver-company"
    );

    if ($dc->delete()) {
      // Update Drivers
      $drivers = Driver::where('company_id', $id)
        ->update(['company_id' => null]);
        
      return response()
        ->json([
          'data' => $data
        ]);
    }
  }
}
