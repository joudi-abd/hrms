<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayrollRequest;
use App\Models\Employee;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $employee = auth()->user();
        $query = Payroll::with(['employee.department'])->latest();
        if (
            $employee->super_admin ||
            $employee->hasAbility('payrolls.view')
        ) {
        } elseif ($employee->hasAbility('payrolls.view_own')) {
            $query->where('employee_id', $employee->id);
        } else {
            abort(403, 'Unauthorized action.');
        }
        
        $request = request();
        $month = $request->input('payroll_month');
        $name = $request->input('name');
        $status = $request->input('status');
        if ($status === 'paid') {
            $query->paid();
        } elseif ($status === 'unpaid') {
            $query->unpaid();
        }
        if ($month) {
            $query->forMonth( $month);
        }
        if ($name) {
            $query->whereHas('employee', function ($q) use ($name) {
                $q->where('name', 'like', "%$name%");
            });
        }
        $payrolls = $query->paginate(10)->withQueryString(); 
        $monthCreated = Payroll::whereMonth('payroll_month',Carbon::now()->month)->whereYear('payroll_month',Carbon::now()->year)->exists();
        $allPaid = !Payroll::whereMonth('payroll_month', Carbon::now()->month)->whereNull('date_paid')->exists();
        return view('payrolls.index' , compact( 'employee','payrolls' , 'monthCreated' , 'allPaid'));
    }

    public function show(Payroll $payroll)
    {
        $this->authorize('view', $payroll);
        return view('payrolls.show', compact('payroll'));
    }

    public function generate(){
        $this->authorize('generate' , Payroll::class);
        $month = request()->input('month' , Carbon::now()->format('Y-m'));
        $employees = Employee::all();
        foreach($employees as $employee){
            $totalWorkingDays = 22; // بفرض وجود 22 يوم عمل في الشهر
            $totalLeaves = $employee->leaves()
            ->where('status' , 'approved')
            ->whereMonth('start_date' , Carbon::parse($month)->month)
            ->whereYear('start_date' , Carbon::parse($month)->year)
            ->sum('total_days');
            $unpaidLeaves = $employee->leaves()
            ->where('status' , 'approved')
            ->whereHas('leaveType' , function($q){
                $q->where('is_paid' , false);
            })
            ->whereMonth('start_date' , Carbon::parse($month)->month)
            ->whereYear('start_date' , Carbon::parse($month)->year)
            ->sum('total_days');
            $apsentDays = $employee->attendances()
            ->where('status' , 'absent')
            ->whereMonth('date' , Carbon::parse($month)->month)
            ->whereYear('date' , Carbon::parse($month)->year)
            ->count();
            $totalUnPaid = $unpaidLeaves + $apsentDays;
            $grossSalary = $employee->salary;
            $deductions = ($grossSalary / $totalWorkingDays) * $totalUnPaid;
            $bonuses = 0; // ممكن إضافة حساب المكافآت بعدين
            $netSalary = $grossSalary - $deductions + $bonuses;
            Payroll::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'payroll_month' => Carbon::parse($month)->format('Y-m-d'),
                ],
                [
                    'paid_leaves' => $totalLeaves - $unpaidLeaves,
                    'unpaid_leaves' => $unpaidLeaves,
                    'gross_salary' => $grossSalary,
                    'deductions' => $deductions,
                    'bonuses' => $bonuses,
                    'net_salary' => $netSalary,
                ]
            );
        }

        return redirect()->back()->with('success' , __('Payrolls generated successfully.'));
    }

    public function pay(Payroll $payroll){
        $this->authorize('pay' , $payroll);
        $payroll->update(['date_paid' => today()]);
        return redirect()->back()->with('success' , __('Payroll marked as paid successfully.'));
    }

    public function payAll(Request $request){
        $this->authorize('pay' , Payroll::class);
        $month = $request->input('month' , Carbon::now()->format('Y-m'));
        $payrolls = Payroll::forMonth($month)->whereNull('date_paid')->get();
        foreach($payrolls as $payroll){
            $payroll->update(['date_paid' => today()]);
        }
        return redirect()->back()->with('success' , __('Paid all successfully.'));
    }
    public function edit(Payroll $payroll)
    {
        $this->authorize('update', $payroll);
        return view('payrolls.edit', compact('payroll'));
    }   

    public function update(PayrollRequest $request, Payroll $payroll)
    {
        $this->authorize('update', $payroll);
        $data = $request->validated();
        // Recalculate net salary
        $data['gross_salary'] = $data['gross_salary'] ?? $payroll->gross_salary;
        $data['deductions'] = $data['deductions'] ?? 0;
        $data['bonuses'] = $data['bonuses'] ?? 0;
        $data['net_salary'] = $data['gross_salary'] - $data['deductions'] + $data['bonuses'];
        $payroll->update($data);
        return redirect()->route('payrolls.index')->with('update', __('Updated successfully.'));
    }

    public function destroy(Payroll $payroll)
    {
        $this->authorize('delete', $payroll);
        $payroll->delete();
        return redirect()->route('payrolls.index')->with('delete', __('Deleted successfully.'));
    }
}
