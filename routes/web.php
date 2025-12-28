<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::prefix(
    LaravelLocalization::setLocale()
    )
    ->get('/', function () {
    return view('welcome');
});


// routes/web.php

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['auth']
    
], function()
{
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');

    Route::get('two-factor-auth',[TwoFactorController::class,'index'])->name('two.factor.auth');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Employees Routes
    Route::resource('employees', EmployeeController::class);

    // Departments Routes
    Route::resource('departments', DepartmentController::class);

    // Payroll Routes
    Route::resource('payrolls', PayrollController::class);
    Route::post('payrolls/generate', [PayrollController::class, 'generate'])->name('payrolls.generate');
    Route::post('payrolls/{payroll}/pay', [PayrollController::class, 'pay'])->name('payrolls.pay');
    Route::post('payrolls/pay-all', [PayrollController::class, 'payAll'])->name('payrolls.pay-all');
    // Attendance Routes
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    Route::get('attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
    Route::get('attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::post('attendance/create-daily', [AttendanceController::class, 'createDailyAttendance'])->name('attendance.create_daily');

    // Leave Requests Routes
    Route::resource('leave-requests', LeaveRequestController::class);
    Route::post('leave-requests/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])->name('leave-requests.approve');
    Route::post('leave-requests/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject');

    // Leave Types Routes
    Route::resource('leave_types', LeaveTypeController::class);

    // Tasks Routes
    Route::get('tasks/all', [TaskController::class, 'allTasks'])->name('tasks.all');
    Route::patch('tasks/{task}/change-status', [TaskController::class, 'changeStatus'])->name('tasks.change_status');
    Route::resource('tasks', TaskController::class);

    // Roles Routes
    Route::resource('roles', RoleController::class);

    // Reports Routes
    Route::get('reports',[ReportController::class,'index'])->name('reports.index');
    Route::get('reports/pdf',[ReportController::class,'exportPDF'])->name('reports.pdf');

    
});




//require __DIR__.'/auth.php';
