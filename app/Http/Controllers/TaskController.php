<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $employee = auth()->user();
        $query = Task::with(['department','creator', 'assignedEmployee'])->latest();
        if(
            $employee->super_admin ||
            $employee->hasAbility('tasks.view')
        ) {
        } elseif ($employee->hasAbility('tasks.view_department')) {
            $query->where('department_id', $employee->department_id);
        } elseif ($employee->hasAbility('tasks.view_own')) {
            $query->where('assigned_to', $employee->id);
        } else {
            abort(403, 'Unauthorized action.');
        }
        $tasks = $query->get(); 
        $departments = Department::all();
        return view('tasks.index' , ['tasks' => $tasks , 'departments' => $departments]);
    }

    public function allTasks()
    {
        $this->authorize('viewAll', Task::class);
        $query = Task::with(['department','creator', 'assignedEmployee'])->latest();
        $request = request();
        $title = $request->input('title');
        $department = $request->input('department_id');
        $status = $request->input('status');
        $prioritize = $request->input('priority');
        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }
        if ($department) {
            $query->where('department_id', $department);
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($prioritize) {
            $query->where('priority', $prioritize);
        }
        $tasks = $query->paginate(10)->withQueryString();
        $departments = Department::all();
        return view('tasks.all' , ['tasks' => $tasks , 'departments' => $departments]);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show' , ['task' => $task]);
    }
    public function create()
    {
        $this->authorize('create', Task::class);
        $departments = Department::all();
        $employees = Employee::all();
        return view('tasks.create' , ['departments' => $departments , 'employees' => $employees]);
    }

    public function store(TaskRequest $request)
    {
        $this->authorize('create', Task::class);
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        Task::create($data);
        return redirect()->back()->with('success', __('Created successfully.'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $departments = Department::all();
        $employees = Employee::all();
        return view('tasks.edit', ['task' => $task , 'departments' => $departments ,'employees' => $employees ]);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $data = $request->validated();
        $task->update($data);
        return redirect()->route('tasks.all')->with('update', __('Updated successfully.'));
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.all')->with('delete', __('Deleted successfully.'));
    }

    public function changeStatus(Task $task)
    {
        $this->authorize('changeStatus', $task);
        if ($task->status === 'pending') {
            $task->status = 'in_progress';
        } elseif ($task->status === 'in_progress') {
            $task->status = 'completed';
            $task->completed_at = now();
        }
        $task->save();
        return redirect()->route('tasks.index')->with('success', __('Updated successfully.'));
    }
}
