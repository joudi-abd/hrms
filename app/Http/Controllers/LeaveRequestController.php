<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequestRequest;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{

    public function index()
    {
        $employee = auth()->user();
        $leaveTypes = LeaveType::all();
        $baseQuery = LeaveRequest::with(['employee.department', 'leaveType'])->latest();

        if (!($employee->super_admin || $employee->hasAbility('leaves.view'))) {
            if ($employee->hasAbility('leaves.view_department')) {
                $baseQuery->whereHas('employee', function ($q) use ($employee) {
                    $q->where('department_id', $employee->department_id);
                });
            } else {
                $baseQuery->where('employee_id', $employee->id);
            }
        }

        $pendingRequests = (clone $baseQuery)
            ->where('status', 'pending')
            ->get();

        $historyRequests = (clone $baseQuery)
            ->whereIn('status', ['approved', 'rejected'])
            ->paginate(10);

        return view('leaves.index', compact('pendingRequests', 'historyRequests' , 'leaveTypes'));
    }

    public function create(){
        $this->authorize('create', LeaveRequest::class);
        $leaveTypes = LeaveType::all();
        return view('leaves.create' , compact('leaveTypes'));
    }

    public function store(LeaveRequestRequest $request){
        $this->authorize('create', LeaveRequest::class);
        $data = $request->validated();
        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $data['total_days'] = $start->diffInDays($end) + 1;
        $data['employee_id'] = auth()->user()->id;
        LeaveRequest::create($data);
        return redirect()->route('leave-requests.index')->with('success', __('Created successfully.'));
    }

    public function show(LeaveRequest $leaveRequest){
        $this->authorize('view', $leaveRequest);
        return view('leaves.show', compact('leaveRequest'));
    }

    public function edit(LeaveRequest $leaveRequest){
        $this->authorize('update', $leaveRequest);
        $leaveTypes = LeaveType::all();
        return view('leaves.edit', compact('leaveRequest', 'leaveTypes'));
    }

    public function update(LeaveRequestRequest $request, LeaveRequest $leaveRequest){
        $this->authorize('update', $leaveRequest);
        $data = $request->validated();
        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $data['total_days'] = $start->diffInDays($end) + 1;
        $leaveRequest->update($data);
        return redirect()->route('leave-requests.index')->with('update', __('Updated successfully.'));
    }

    public function destroy(LeaveRequest $leaveRequest){
        $this->authorize('delete', $leaveRequest);
        $leaveRequest->delete();
        return redirect()->route('leave-requests.index')->with('delete', __('Deleted successfully.'));
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        $this->authorize('approve', $leaveRequest);

        $leaveRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->user()->id
        ]);
        $attendance = Attendance::where('employee_id', $leaveRequest->employee_id)
            ->whereDate('date', '>=', $leaveRequest->start_date)
            ->whereDate('date', '<=', $leaveRequest->end_date)
            ->get();
        foreach ($attendance as $attend) {
            $attend->update([
                'status' => 'leave',
                'work_hours' => 0,
                'check_in' => '-',
                'check_out' => '-',
            ]);
        }

        return redirect()->back()
            ->with('success', __('Leave request approved successfully.'));
    }

    public function reject(LeaveRequest $leaveRequest){
        $this->authorize('reject', $leaveRequest);
        $leaveRequest->update([
        'status' => 'rejected',
        'approved_by' => auth()->user()->id
        ]);
        return redirect()->back()->with('success', __('Leave request rejected successfully.'));
    }
}


