<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Models\Features\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest()->paginate(10);
        return view('feature.departments.list_department', compact('departments'));
    }

    public function create()
    {
        return view('feature.departments.create_department');
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'code'        => ['required', 'string', 'max:50', 'unique:departments,code'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:active,inactive'],
        ]);

        Department::create($request->only('name', 'code', 'description', 'status'));

        return redirect()->route('feature.departments.list_department')->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        return view('feature.departments.show_department', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('feature.departments.edit_department', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'code'        => ['required', 'string', 'max:50', 'unique:departments,code,' . $department->id],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:active,inactive'],
        ]);

        $department->update($request->only('name', 'code', 'description', 'status'));

        return redirect()->route('feature.departments.list_partment')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('feature.departments.list_department')->with('success', 'Department deleted successfully.');
    }
}