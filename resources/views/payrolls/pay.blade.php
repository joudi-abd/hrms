<div class="modal fade" id="payPayrollModal{{ $payroll->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-money-bill-wave text-success"></i>
                    {{ __('Pay Salary') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="mb-2">
                    {{ __('Are you sure you want to mark this salary as paid?') }}
                </p>

                <h5 class="fw-bold mt-3">
                    {{ $payroll->employee->name }}
                </h5>

                <p class="text-muted">
                    {{ $payroll->payroll_month->format('F Y') }}
                </p>

                <div class="alert alert-success">
                    <strong>{{ __('Net Salary') }}:</strong>
                    {{ number_format($payroll->net_salary, 2) }}
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('Cancel') }}
                </button>

                <form method="POST" action="{{ route('payrolls.pay', $payroll) }}">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> {{ __('Confirm Payment') }}
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- Pay All --}}
<div class="modal fade" id="payAllModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('payrolls.pay-all') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Pay All Unpaid Payrolls') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Month') }}</label>
                        <input type="month"
                               name="payroll_month"
                               class="form-control"
                               required>
                    </div>

                    <div class="alert alert-warning">
                        {{ __('This action will mark all unpaid payrolls for the selected month as paid.') }}
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-success">
                        {{ __('Confirm & Pay') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>