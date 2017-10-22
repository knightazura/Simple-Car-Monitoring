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
            $employees = Employee::select('nip', 'employee_name')->get();
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
        $meta = "Create";
        return view('employee.form', compact('meta'));
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

        if ($employee) return redirect()->route('employee.index')->with('success', "Data Pegawai baru ({$request->employee_name}) berhasil dibuat!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $meta = "Edit";
        $employee = Employee::findOrFail($id);

        return view('employee.form', compact('meta', 'employee'));
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
        
        if ($employee->save()) return redirect()->route('employee.index')->with('success', 'Data pegawai berhasil diubah!');
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
