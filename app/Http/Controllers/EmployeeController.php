<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::orderBy('id','desc')->paginate(3);
        foreach($employees as $employee){
            $company_details[] = Company::where('id', $employee->company_id)->get()->first();
        }

        return view('employee.index', compact('employees', 'company_details'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'phone' => 'required|numeric|digits:10',
        ]);

        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->company_id = Company::where('name', trim($request->company))->first()->id;
        $employee->phone = $request->phone;
        $employee->save();
        return redirect()->route('employee.index')->with('success','Employee Has Been added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('employee.show',compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $company_details = Company::where('id', $employee->company_id)->get()->first();
        $company_name = $company_details->name;
        return view('employee.edit',compact('employee', 'company_name'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::find($id);
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email,'.$employee->id,
            'phone' => 'required|numeric|digits:10',
        ]);

        $employee = Employee::find($id);
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->email = $request->email;
        $employee->company_id = Company::where('name', trim($request->company))->first()->id;
        $employee->phone = $request->phone;
        $employee->save();
        return redirect()->route('employee.index')->with('success','Employee Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employee.index')->with('success','Employee has been deleted successfully');
    }
}
