<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Alert;
use Excel;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::orderBy('updated_at', 'desc')->get();
        return view('employee.index', compact('employees'));
    }

    public function available()
    {
        $employees = Employee::doesntHave('request')->get();
        return response()
            ->json([
                'model' => $employees
            ]);
    }

    public function editAvailable($id)
    {
        $cu = \App\Models\CarUsage::findOrFail($id);
        $employees = Employee::doesntHave('request')
            ->orWhere('nip', $cu->nip)
            ->get();

        return response()
            ->json([
                'model' => $employees
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
        return view('employee.form', compact('data'));
    }

    public function apiCreate()
    {
        $data['positions'] = $this->createDistinctApiData('\App\Models\Employee', 'employee_position');
        $data['divisions'] = $this->createDistinctApiData('\App\Models\Employee', 'division');
        return response()->json(['model' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $data = $this->validate(request(), [
            'nip' => 'required|min:6',
            'employee_name' => 'required|min:3',
            'employee_position' => 'required|string',
            'division' => 'required|string'
        ]);

        // Store
        $employee = Employee::create($data);

        if ($employee) {
            return response()
                ->json([
                    'message' => "Data pegawai ({$request->employee_name}) berhasil ditambahkan!",
                    'redirect_url' => '/employee'
                ]);
        }
    }

    public function insertBatch(Request $request)
    {
        $a = Excel::load($request->file('excel'))->get();
        foreach ($a as $key => $value) {
            $data[$key]['nip'] = (string)$value->nip;
            $data[$key]['employee_name'] = $value->nama_pegawai;
            $data[$key]['employee_position'] = $value->jabatan;
            $data[$key]['division'] = $value->divisi;
            $data[$key]['created_at'] = date('Y-m-d H:i:s');
            $data[$key]['updated_at'] = date('Y-m-d H:i:s');
        }

        if (DB::table('employees')->insert($data)) {
            alert()->success('Upload data pegawai berhasil!', 'Status');
            return redirect()->route('employee.index');
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
        $employee = Employee::findOrFail($id);
        return response()->json(['model' => $employee]);
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
        return view('employee.form', compact('data'));
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
        $employee = Employee::findOrFail($id);

        // Validation
        $data = $this->validate(request(), [
            'nip' => 'required|min:3',
            'employee_name' => 'required|min:3',
            'employee_position' => 'required|string',
            'division' => 'required|string'
        ]);

        // Fill fields & update
        $employee->fill($data);

        // Update on child too if any
        $goinEmployee = \App\Models\CarUsage::where('nip', $id)->get();
        if ($goinEmployee->isNotEmpty()) {
            $goinEmployee = $goinEmployee[0];
            $goinEmployee->nip = $request->nip;
            $goinEmployee->save();
        }
        
        if ($employee->save()) {
            return response()
                ->json([
                    'message' => "Data pegawai ({$request->employee_name}) berhasil diubah!",
                    'redirect_url' => '/employee'
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
        $employee   = Employee::findOrFail($id);
        $data       = array(
            'message' => "Data Pegawai {$employee->employee_name} telah berhasil dihapus!",
            'redirect_url' => "/employee"
        );

        // Destroy entity
        if ($employee->delete()) {
            return response()
                ->json([
                    'data' => $data
                ]);
        }
    }

    public function downloadTemplateBatch()
    {
        $path = 'files/batch_employee_template.xlsx';
        return response()->download(storage_path($path));
    }
}
