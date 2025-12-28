<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = auth()->user();
        if($employee->can('viewOwn' , Employee::class) && !$employee->can('viewAny', Employee::class)){
            return redirect()->route('employees.show' , $employee->id);
        }

        $query = Employee::with('department')->latest();
        if ($employee->super_admin ||
            $employee->hasAbility('employees.view')) {
            // No additional constraints
        } elseif ($employee->hasAbility('employees.view_department')) {
            $query->where('department_id', $employee->department_id);
        } else {
            abort(403);
        }
        $request = request();
        $name = $request->input('name');
        $status = $request->input('status');
        $department = $request->input('department_id');
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($department) {
            $query->where('department_id', $department);
        }
        $employees = $query->where('super_admin', false)->paginate(10);
        return view('employees.index' , [
            'employees' => $employees,
            'departments' => Department::all()
        ]);
    }

    public function create()
    {
        // if(Gate::denies('employees.create')){
        //     abort(403);
        // }
        $this->authorize('create', Employee::class);
        $roles = Role::all();
        $departments = Department::all();
        return view('employees.create',['departments' => $departments , 'roles' => $roles]);
    }

    public function store(EmployeeRequest $request)
    {
        // if(Gate::denies('employees.create')){
        //     abort(403);
        // }
        $this->authorize('create', Employee::class);
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $employee = Employee::create($data);
        if (isset($data['role_id'])) {
            $employee->roles()->attach($data['role_id']);
        }
        return redirect()->route('employees.index')->with('success', __('Created successfully.'));
    }

    public function edit(Employee $employee)
    {
        // if(Gate::denies('employees.edit')){
        //     abort(403);
        // }
        $this->authorize('update', $employee);
        $roles = Role::all();
        $departments = Department::all();
        return view('employees.edit', ['employee' => $employee, 'departments' => $departments , 'roles' => $roles]);
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        // if(Gate::denies('employees.edit')){
        //     abort(403);
        // }
        $this->authorize('update', $employee);
        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']);
        }
        else {
            $data['password'] = Hash::make($data['password']);
        }
        if (isset($data['role_id'])) {
            $employee->roles()->sync($data['role_id']);
        } else {
            $employee->roles()->detach();
        }
        return redirect()->route('employees.index')->with('update', __('Updated successfully.'));
    }

    public function destroy(Employee $employee)
    {
        // if(Gate::denies('employees.delete')){
        //     abort(403);
        // }
        $this->authorize('delete', $employee);
        $employee->delete();
        return redirect()->route('employees.index')->with('delete', __('Deleted successfully.'));
    }

    public function show(Employee $employee)
    {
        // if(Gate::denies('employees.view')){
        //     abort(403);
        // }
        $this->authorize('view', $employee);
        return view('employees.show', ['employee' => $employee]);
    }
}
