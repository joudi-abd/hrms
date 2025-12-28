<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\Payroll;

class DashboardController extends Controller
{
    public function index()
    {
        // إجمالي الموظفين
        $totalEmployees = Employee::count();

        // الموظفون الجدد هذا الشهر
        $newEmployeesThisMonth = Employee::whereMonth('created_at', now()->month)->count();

        // إجمالي الأقسام
        $totalDepartments = Department::count();

        // الأقسام النشطة (مثلاً: بها موظفون نشطون)
        $activeDepartments = Department::has('employees', '>', 0)->count();

        // الحضور اليوم
        $presentToday = Attendance::whereDate('date', now())->where('status', 'present')->count();
        $absentToday = Attendance::whereDate('date', now())->where('status', 'absent')->count();

        // طلبات الإجازة
        $pendingLeaves = LeaveRequest::where('status', 'pending')->get();
        $pendingLeavesCount = LeaveRequest::where('status', 'pending')->count();
        $approvedLeaves = LeaveRequest::where('status', 'approved')->count();

        // الرواتب
        $totalPayrollThisMonth = Payroll::whereMonth('payroll_month', now()->month)->sum('net_salary');
        $paidPayrollThisMonth = Payroll::whereMonth('payroll_month', now()->month)->where('date_paid')->sum('net_salary');

        // المهام المعلقة والمكتملة (Tasks model لو موجود)
        $tasks = Task::all();
        $pendingTasks = Task::where('status', 'pending')->count();
        $processingTasks = Task::where('status', 'in_progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();

        // أحدث الموظفين
        $activeEmployees = Employee::where('status', 'active')->count();
        $latestEmployees = Employee::with('department')->orderBy('created_at', 'desc')->limit(5)->get();

        // بيانات الرسوم البيانية
        $months = collect(range(1, 12))->map(function ($m) {
            return date('M', mktime(0, 0, 0, $m, 1)); });

        $monthlyPresent = [];
        $monthlyAbsent = [];
        $monthlyPayroll = [];

        foreach (range(1, 12) as $month) {
            $monthlyPresent[] = Attendance::whereMonth('date', $month)->where('status', 'present')->count();
            $monthlyAbsent[] = Attendance::whereMonth('date', $month)->where('status', 'absent')->count();
            $monthlyPayroll[] = Payroll::whereMonth('payroll_month', $month)->sum('net_salary');
        }

        $employee = auth()->user();
        $leaveTypes = \App\Models\LeaveType::all();
        $leaveBalances = [];

        foreach ($leaveTypes as $type) {
            $takenDays = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type_id', $type->id)
                ->where('status', 'approved')
                ->whereYear('start_date', now()->year)
                ->sum('total_days');

            $leaveBalances[$type->name] = [
                'total' => $type->max_days_per_year,
                'taken' => $takenDays,
                'remaining' => max(0, $type->max_days_per_year - $takenDays)
            ];
        }
        return view('dashboard.index', compact(
            'totalEmployees',
            'newEmployeesThisMonth',
            'totalDepartments',
            'activeDepartments',
            'presentToday',
            'absentToday',
            'pendingLeaves',
            'pendingLeavesCount',
            'approvedLeaves',
            'totalPayrollThisMonth',
            'paidPayrollThisMonth',
            'tasks',
            'pendingTasks',
            'processingTasks',
            'completedTasks',
            'activeEmployees',
            'latestEmployees',
            'months',
            'monthlyPresent',
            'monthlyAbsent',
            'monthlyPayroll',
            'leaveBalances'
        ));
    }
}