<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $employee = auth()->user();
        $query = Attendance::with(['employee.department'])->latest();
        if (
            $employee->super_admin ||
            $employee->hasAbility('attendance.view')
        ) {
        } elseif ($employee->hasAbility('attendance.view_department')) {
            $query->whereHas('employee', function ($q) use ($employee) {
                $q->where('department_id', $employee->department_id);
            });

        } else {
            $query->where('employee_id', $employee->id);
        }
        $userAttendanceToday = auth()->user()->attendances()->whereDate('date', today())->first();      
        $attendances = $query->paginate(15);
        $todayCreated = Attendance::whereDate('date', today())->exists();
        return view('attendances.index', compact('employee','attendances', 'userAttendanceToday' ,'todayCreated'));
    }

    public function checkIn()
    {
        $this->authorize('checkIn', Attendance::class);
        $employee = auth()->user();
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', today())
            ->firstOrFail();
        if ($attendance->check_in) {
            return redirect()->back()->with('error', __('You have already checked in today.'));
        }
        if($attendance->status == 'leave'){
            return redirect()->back()->with('error', __('You cannot check in on a leave day.'));
        }

        $attendance->update(
            ['check_in' => now()->format('H:i:s'), 'status' => 'present']
        );
        return redirect()->back()->with('success', __('Checked in successfully.'));
    }

    public function checkOut()
    {
        $employee = auth()->user();
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('date', today())
            ->firstOrFail();
        $this->authorize('checkOut', $attendance);
        if (!$attendance || !$attendance->check_in) {
            return redirect()->back()->with('error', __('You need to check in first.'));
        }
        if ($attendance->check_out) {
            return redirect()->back()->with('error', __('You have already checked out today.'));
        }
        $checkIn = Carbon::parse($attendance->check_in);
        $checkOut = now();
        $workHours = $checkOut->diffInMinutes($checkIn) / 60;
        $attendance->update([
            'check_out' => $checkOut->format('H:i:s'),
            'work_hours' => round($workHours, 2),
        ]);
        return redirect()->back()->with('success', __('Checked out successfully.'));
    }

    public function edit(Attendance $attendance)
    {
        $this->authorize('update', $attendance);
        return view('attendances.edit', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $this->authorize('update', $attendance);
        $request->validate([
            'check_in' => 'nullable',
            'check_out' => 'nullable|after:check_in',
            'status' => 'nullable|in:present,absent,leave,half_day',
        ]);

        $workHours = 0;
        if ($request->check_in && $request->check_out) {
            $checkIn = Carbon::parse($request->date .$request->check_in);
            $checkOut = Carbon::parse($request->date .$request->check_out);
            $workHours = $checkOut->diffInMinutes($checkIn) / 60;
        }

        $attendance->update([
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'work_hours' => round($workHours, 2),
            'status' => 'present',
        ]);

        return redirect()->route('attendance.index')->with('update', __('Updated successfully.'));
    }

    public function destroy(Attendance $attendance)
    {
        $this->authorize('delete', $attendance);
        $attendance->delete();
        return redirect()->route('attendance.index')->with('delete', __('Deleted successfully.'));
    }

    public function show(Attendance $attendance)
    {
        $this->authorize('view', $attendance);
        return view('attendances.show', compact('attendance'));
    }

    public function createDailyAttendance()
    {
        $this->authorize('createDaily', Attendance::class);

        $today = today();

        $employees = \App\Models\Employee::all();
        foreach ($employees as $employee) {
            $attendance = Attendance::firstOrCreate(
                [
                    'employee_id' => $employee->id,
                    'date' => $today
                ],
                [
                    'status' => 'absent'
                ]
            );
        }

        $leaveEmployeeIds = \App\Models\LeaveRequest::where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->pluck('employee_id');

        Attendance::whereDate('date', $today)
            ->whereIn('employee_id', $leaveEmployeeIds)
            ->update([
                'status' => 'leave',
                'check_in' => '-',
                'check_out' => '-',
                'work_hours' => 0
            ]);

        return redirect()->back()
            ->with('success', __('Created successfully.'));
    }
}
