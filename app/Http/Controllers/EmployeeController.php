<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Exports\EmployeeExport;
use App\Models\Imports\EmployeeImport;
use Illuminate\Http\Request;
use Excel;
use Exception;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function importForm()
    {
        return view('employees.import');
    }
    public function import()
    {
        Employee::truncate();
        Excel::import(new EmployeeImport, request()->file('file'));
        return redirect('/employees');
    }

    public function export()
    {
        return Excel::download(new EmployeeExport, 'employee.xlsx');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Employee::query();
        foreach(Employee::$filterFields as $filterField) {
            if ($request->has($filterField)) {
                $query->where($filterField, $request->input($filterField));
            }
        }

        $employees = $query->get();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    private function validateEmployee(Request $request) {
        $request->validate([
            'name' => 'required',
            'faculty' => 'required',
            'award' => 'required',
            'state_award' => 'required',
            'protocol' => 'required',
            'award_year' => 'required',
            'is_state_award' => 'boolean',
            // 'state_award_year' => 'required'
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateEmployee($request);

        Employee::create($request->all());

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $this->validateEmployee($request);

        $employee->update($request->all());

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully');
    }
}
