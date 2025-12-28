<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveTypeRequest;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', LeaveType::class);
        $leaveTypes = LeaveType::latest()->paginate(10);
        return view('leaveTypes.index', compact('leaveTypes'));
    }

    public function create()
    {
        $this->authorize('create', LeaveType::class);
        return view('leaveTypes.create');
    }

    public function store(LeaveTypeRequest $request)
    {
        $this->authorize('create', LeaveType::class);
        LeaveType::create($request->validated());
        return redirect()->route('leave_types.index')->with('success', __('Created successfully.'));
    }

    public function edit(LeaveType $leave_type)
    {
        $this->authorize('update', $leave_type);
        return view('leaveTypes.edit', compact('leave_type'));
    }

    public function update(LeaveTypeRequest $request, LeaveType $leave_type)
    {
        $this->authorize('update', $leave_type);
        $leave_type->update($request->validated());
        return redirect()->route('leave_types.index')->with('update', __('Updated successfully.'));
    }

    public function destroy(LeaveType $leave_type)
    {
        $this->authorize('delete', $leave_type);
        $leave_type->delete();
        return redirect()->route('leave_types.index')->with('delete', __( 'Deleted successfully.'));
    }
}
