<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::orderBy('updated_at', 'desc')->paginate(10);
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
}
