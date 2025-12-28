<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\LeaveRequest;
use App\Models\Task;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Report::class);
        $active = $request->query('page', 'attendance');
        $Statuses = [];
        $kpis = [];

        $filters = $request->only([
            'from',
            'to',
            'status',
            'employee_id'
        ]);
        $employees = Employee::all();

        // Payroll
        $payrollStats = [];
        $payrollTrend = [];
        $payrollPaidUnpaid = [];
        if ($active === 'payroll') {

            $baseQuery = Payroll::applyFilters($filters);

            $payrollStats = (clone $baseQuery)
                ->select(DB::raw('MONTH(payroll_month) as month'), DB::raw('SUM(net_salary) as total'))
                ->groupBy(DB::raw('MONTH(payroll_month)'))
                ->get();

            $kpis = [
                'total_net' => (clone $baseQuery)->sum('net_salary'),
                'total_gross' => (clone $baseQuery)->sum('gross_salary'),
                'deductions' => (clone $baseQuery)->sum('deductions'),
                'bonuses' => (clone $baseQuery)->sum('bonuses'),
                'paid' => (clone $baseQuery)->paid()->count(),
                'unpaid' => (clone $baseQuery)->unpaid()->count(),
            ];

            $payrollTrend = Payroll::applyFilters($filters)->select(
                DB::raw('MONTH(payroll_month) as month'),
                DB::raw('SUM(net_salary) as net'),
                DB::raw('SUM(gross_salary) as gross'),
                DB::raw('SUM(deductions) as deductions')
            )
                ->groupBy(DB::raw('MONTH(payroll_month)'))
                ->orderBy('month')
                ->get();

            $paid = (clone $baseQuery)->paid()->count();
            $unpaid = (clone $baseQuery)->unpaid()->count();
            $Statuses = [
                'paid',
                'unpaid'
            ];
        }

        // Attendance
        $attendanceStats = [];
        $attendanceTrend = [];
        if ($active === 'attendance') {

            $baseQuery = Attendance::applyFilters($filters);

            $attendanceStats = (clone $baseQuery)
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();

            $kpis = [
                'total_records' => (clone $baseQuery)->count(),
                'present' => (clone $baseQuery)->where('status', 'present')->count(),
                'absent' => (clone $baseQuery)->where('status', 'absent')->count(),
                'leave' => (clone $baseQuery)->where('status', 'leave')->count(),
            ];

            $Statuses = Attendance::select('status')->distinct()->pluck('status')->toArray();

            $attendanceTrend = Attendance::applyFilters($filters)->select(
                DB::raw('DATE(date) as day'),
                DB::raw('COUNT(*) as count')
            )
                ->where('status', 'present')
                ->groupBy(DB::raw('DATE(date)'))
                ->orderBy('day')
                ->take(14)
                ->get();
        }



        // Leaves
        $leavesTrend = [];
        $leavesByStats = [];
        if ($active === 'leaves') {

            $baseQuery = LeaveRequest::applyFilters($filters);

            // Stats حسب الفلاتر
            $leavesByStats = (clone $baseQuery)
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status');

            // KPIs مع فلاتر
            $kpis = [
                'total' => (clone $baseQuery)->count(),
                'approved' => (clone $baseQuery)->where('status', 'approved')->count(),
                'rejected' => (clone $baseQuery)->where('status', 'rejected')->count(),
                'total_days' => (clone $baseQuery)->where('status', 'approved')
                    ->sum(DB::raw('DATEDIFF(end_date, start_date) + 1')),
                'paid' => (clone $baseQuery)->where('status', 'approved')
                    ->whereHas('leaveType', function ($q) {
                        $q->where('is_paid', true);
                    })->count(),
                'unpaid' => (clone $baseQuery)->where('status', 'approved')
                    ->whereHas('leaveType', function ($q) {
                        $q->where('is_paid', false);
                    })->count(),
            ];

            // Trend: مجموع أيام الإجازة لكل شهر
            $leavesTrend = (clone $baseQuery)->where('status', 'approved')
                ->select(
                    DB::raw('MONTH(start_date) as month'),
                    DB::raw('SUM(DATEDIFF(end_date, start_date) + 1) as days')
                )
                ->groupBy(DB::raw('MONTH(start_date)'))
                ->orderBy('month')
                ->get();

            $Statuses = LeaveRequest::select('status')->distinct()->pluck('status')->toArray();
        }
        // Tasks
        $tasksStats = [];
        $taskData = [];
        $departmentLabels = [];
        $departmentCompletedTasks = [];

        if ($active === 'tasks') {

            $baseQuery = Task::applyFilters($filters);

            // Stats حسب الفلاتر
            $taskData = (clone $baseQuery)
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status');

            $tasksStats = [
                $taskData['pending'] ?? 0,
                $taskData['in_progress'] ?? 0,
                $taskData['completed'] ?? 0,
            ];

            // KPIs مع فلاتر
            $kpis = [
                'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
                'in_progress' => (clone $baseQuery)->where('status', 'in_progress')->count(),
                'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
                'overdue' => (clone $baseQuery)->where('due_date', '<', now())->where('status', '!=', 'completed')->count(),
            ];

            $Statuses = Task::select('status')->distinct()->pluck('status')->toArray();

            // Department stats
            $departmentStats = Department::withCount([
                'tasks as completed_tasks_count' => function ($query) use ($filters) {
                    $query->where('status', 'completed');
                    // لو تحبي كمان تطبيق فلاتر خاصة بـ tasks على الأقسام:
                    if (!empty($filters['employee_id'])) {
                        $query->where('assigned_to', $filters['employee_id']);
                    }
                }
            ])->get();

            $departmentLabels = $departmentStats->pluck('name');
            $departmentCompletedTasks = $departmentStats->pluck('completed_tasks_count');
        }


        $colors = [
            'attendance' => [
                'total_records' => '#98c1ffff',
                'present' => '#9cda9eff',
                'absent' => '#ffac95ff',
                'leave' => '#6d6d6dff',
            ],
            'payroll' => [
                'total_net' => '#98c1ffff',
                'total_gross' => '#9cda9eff',
                'deductions' => '#ffad96ff',
                'bonuses' => '#6d6d6dff',
                'paid' => '#a0e7e5ff',
                'unpaid' => '#ffcbf1ff',
            ],
            'leaves' => [
                'total' => '#98c1ffff',
                'approved' => '#9cda9eff',
                'rejected' => '#ffad96ff',
                'total_days' => '#6d6d6dff',
                'paid' => '#a0e7c2ff',
                'unpaid' => '#f9c3ebff',
            ],
            'tasks' => [
                'pending' => '#ffe38eff',
                'in_progress' => '#98c1ffff',
                'completed' => '#9cda9eff',
                'overdue' => '#ffad96ff',
            ],
        ];

        $icons = [
            'attendance' => [
                'total_records' => 'bi bi-journal-check',
                'present' => 'bi bi-person-check-fill',
                'absent' => 'bi bi-person-x-fill',
                'leave' => 'bi bi-person-lines-fill',
            ],
            'payroll' => [
                'total_net' => 'bi bi-currency-dollar',
                'total_gross' => 'bi bi-wallet2',
                'deductions' => 'bi bi-arrow-down-circle',
                'bonuses' => 'bi bi-arrow-up-circle',
                'paid' => 'bi bi-check-circle',
                'unpaid' => 'bi bi-x-circle',
            ],
            'leaves' => [
                'total' => 'bi bi-calendar-check',
                'approved' => 'bi bi-check-lg',
                'rejected' => 'bi bi-x-lg',
                'total_days' => 'bi bi-calendar-day',
                'paid' => 'bi bi-cash-stack',
                'unpaid' => 'bi bi-wallet-fill',
            ],
            'tasks' => [
                'pending' => 'bi bi-hourglass-split',
                'in_progress' => 'bi bi-gear-fill',
                'completed' => 'bi bi-check2-square',
                'overdue' => 'bi bi-exclamation-triangle-fill',
            ],
        ];

        return view('reports.index', compact(
            'active',
            'kpis',
            'attendanceStats',
            'attendanceTrend',
            'payrollStats',
            'payrollTrend',
            'payrollPaidUnpaid',
            'leavesByStats',
            'leavesTrend',
            'taskData',
            'tasksStats',
            'departmentLabels',
            'departmentCompletedTasks',
            'colors',
            'icons',
            'Statuses',
            'employees'
        ));
    }


    public function exportPDF(Request $request)
    {
        $this->authorize('export' , Report::class);
        $active = $request->query('page', 'attendance');
        $filters = $request->only([
            'from',
            'to',
            'status',
            'employee_id'
        ]);
        $attendanceStats = [];
        $attendanceTrend = [];
        $payrollStats = [];
        $payrollTrend = [];
        $leavesByStats = [];
        $leavesTrend = [];
        $taskData = [];
        $tasksStats = [];
        $departmentLabels = [];
        $departmentCompletedTasks = [];
        $kpis = [];
        
        if ($active === 'attendance'){
            $baseQuery = Attendance::applyFilters($filters);
            $kpis = [
                'total_records' => (clone $baseQuery)->count(),
                'present' => (clone $baseQuery)->where('status', 'present')->count(),
                'absent' => (clone $baseQuery)->where('status', 'absent')->count(),
                'leave' => (clone $baseQuery)->where('status', 'leave')->count(),
            ];
            $attendanceStats = (clone $baseQuery)
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();

        }

        if($active === 'payroll'){
            $baseQuery = Payroll::applyFilters($filters);
            $kpis = [
                'total_net' => (clone $baseQuery)->sum('net_salary'),
                'total_gross' => (clone $baseQuery)->sum('gross_salary'),
                'deductions' => (clone $baseQuery)->sum('deductions'),
                'bonuses' => (clone $baseQuery)->sum('bonuses'),
                'paid' => (clone $baseQuery)->paid()->count(),
                'unpaid' => (clone $baseQuery)->unpaid()->count(),
            ];
            $payrollStats = (clone $baseQuery)
                ->select(DB::raw('MONTH(payroll_month) as month'), DB::raw('SUM(net_salary) as total'))
                ->groupBy(DB::raw('MONTH(payroll_month)'))
                ->get();
        }

        if($active === 'leaves'){
            $baseQuery = LeaveRequest::applyFilters($filters);
            $kpis = [
                'total' => (clone $baseQuery)->count(),
                'approved' => (clone $baseQuery)->where('status', 'approved')->count(),
                'rejected' => (clone $baseQuery)->where('status', 'rejected')->count(),
                'total_days' => (clone $baseQuery)->where('status', 'approved')
                    ->sum(DB::raw('DATEDIFF(end_date, start_date) + 1')),
                'paid' => (clone $baseQuery)->where('status', 'approved')
                    ->whereHas('leaveType', function ($q) {
                        $q->where('is_paid', true);
                    })->count(),
                'unpaid' => (clone $baseQuery)->where('status', 'approved')
                    ->whereHas('leaveType', function ($q) {
                        $q->where('is_paid', false);
                    })->count(),
            ];
            $leavesByStats = (clone $baseQuery)
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status');
        }

        if($active === 'tasks'){
            $baseQuery = Task::applyFilters($filters);
            $kpis = [
                'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
                'in_progress' => (clone $baseQuery)->where('status', 'in_progress')->count(),
                'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
                'overdue' => (clone $baseQuery)->where('due_date', '<', now())->where('status', '!=', 'completed')->count(),
            ];
            $taskData = (clone $baseQuery)
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status');

            $tasksStats = [
                $taskData['pending'] ?? 0,
                $taskData['in_progress'] ?? 0,
                $taskData['completed'] ?? 0,
            ];
        }

        $pdf = Pdf::loadView('reports.pdf', compact(
            'active', 
            'kpis', 
            'leavesByStats',
            'attendanceTrend',
            'payrollTrend',
            'leavesTrend',
            'taskData',
            'departmentLabels',
            'departmentCompletedTasks', 
            'filters',
            'attendanceStats',
            'payrollStats',
            'tasksStats'            
        ));

        return $pdf->download("report-{$active}-".now()->format('Y-m-d')."_report.pdf");
    }
}