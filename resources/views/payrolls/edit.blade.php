@extends('layouts.app')
@section('title', 'Payrolls')
@section('content')
    <div class="container px-6 py-4">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div>
                    <div class="border-bottom pb-4">
                        <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
                            <h2 class="mb-0 fw-bold">{{__('Edit Payroll Record')}}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-6">
                <div class="row mb-6">
                    @if ($errors->any())
                        <div class="alert alert-danger w-100">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <x-form.form method="PUT" action="{{ route('payrolls.update', $payroll->id) }}">
                                    @include('payrolls._form')
                                    <div class="d-flex gap-2 mt-4 justify-content-between">
                                        <button type="submit" class="btn btn-primary w-100">{{__('Update')}}</button>
                                        <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">{{__('Back')}}</a>
                                    </div>
                                </x-form.form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const grossInput = document.querySelector('input[name="gross_salary"]');
    const unpaidLeavesInput = document.querySelector('input[name="unpaid_leaves"]');
    const bonusesInput = document.querySelector('input[name="bonuses"]');
    const deductionsInput = document.querySelector('input[name="deductions"]');
    const netSalaryInput = document.querySelector('input[name="net_salary"]');
    const workingDaysInput = document.querySelector('input[name="total_working_days"]');

    function updateSalary() {
        const gross = parseFloat(grossInput.value) || 0;
        const unpaidLeaves = parseInt(unpaidLeavesInput.value) || 0;
        const bonuses = parseFloat(bonusesInput.value) || 0;
        const workingDays = parseInt(workingDaysInput.value) || 22;

        // حساب الخصم تلقائياً
        const dailyRate = workingDays > 0 ? gross / workingDays : 0;
        const deductions = dailyRate * unpaidLeaves;

        deductionsInput.value = deductions.toFixed(2);
        netSalaryInput.value = (gross - deductions + bonuses).toFixed(2);
    }

    grossInput.addEventListener('input', updateSalary);
    unpaidLeavesInput.addEventListener('input', updateSalary);
    bonusesInput.addEventListener('input', updateSalary);

    updateSalary(); // حساب مبدئي
});
</script>
@endpush