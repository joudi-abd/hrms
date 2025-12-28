<div class="row g-3">
<input type="hidden" name="total_working_days" value="22">
<div class="row">
    <div class="col-md-6">
        <x-form.input
        name="employee_id"
        label="Employee name"
        :value="$payroll->employee->name"
        readonly
        />
    </div>
    <div class="col-md-6">
    <x-form.input
        name="department_id"
        label="Department name"
        :value="$payroll->employee->department->name ?? 'N/A'"
        readonly
        />
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <x-form.input
        type="month"
        name="payroll_month"
        label="Payroll Month"
        :value="old('payroll_month', isset($payroll) ? $payroll->payroll_month->format('Y-m') : '')"
        readonly
        />
    </div>
    <div class="col-md-6">
        <x-form.input
        name="date_paid"
        label="Date Paid"
        type="date"
        :value="old('date_paid', isset($payroll) ? $payroll->date_paid ?->format('Y-m-d') : '')"
        />
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <x-form.input
        name="gross_salary"
        label="Gross Salary"
        type="number"
        step="0.01"
        :value="old('gross_salary', isset($payroll) ? $payroll->gross_salary : '')"
        />
    </div>
    <div class="col-md-6">
        <x-form.input
        name="net_salary"
        label="Net Salary"
        type="number"
        step="0.01"
        :value="old('net_salary', isset($payroll) ? $payroll->net_salary : '')"
        readonly
        />
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <x-form.input
        name="bonuses"
        label="Bonuses"
        type="number"
        step="0.01"
        :value="old('bonuses', isset($payroll) ? $payroll->bonuses : '')"
        />
    </div>
    <div class="col-md-6">
        <x-form.input
        name="deductions"
        label="Deductions"
        type="number"
        step="0.01"
        :value="old('deductions', isset($payroll) ? $payroll->deductions : '')"
        readonly
        />
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <x-form.input
        name="paid_leaves"
        label="Paid Leaves"
        type="number"
        :value="old('paid_leaves', isset($payroll) ? $payroll->paid_leaves : '')"
        />
    </div>
    <div class="col-md-6">
        <x-form.input
        name="unpaid_leaves"
        label="Unpaid Leaves"
        type="number"
        :value="old('unpaid_leaves', isset($payroll) ? $payroll->unpaid_leaves : '')"
        />
    </div>
</div>
    
</div>