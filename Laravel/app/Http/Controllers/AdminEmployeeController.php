<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Validator; // Import Validator facade

class AdminEmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees); // Return JSON
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ // Use Validator facade
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'post' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Return JSON errors
        }

        $employee = Employee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'post' => $request->post,
            'salary' => $request->salary,
            'status' => $request->status,
            'admin_id' => Auth::user()->id, // Use Auth facade
        ]);

        return response()->json($employee, 201); // Return JSON with 201 status (created)
    }


    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee); // Return JSON
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'post' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422); // Return JSON errors
        }

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return response()->json($employee, 200); // Return JSON with 200 status (OK)
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(null, 204); // Return JSON with 204 status (No Content - successful delete)
    }
}