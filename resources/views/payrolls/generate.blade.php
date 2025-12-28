<div class="modal fade" id="generatePayrollModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-cogs text-primary"></i>
                    {{ __('Generate Payrolls') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('payrolls.generate') }}">
                @csrf

                <div class="modal-body">

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ __('Payrolls will be generated for all employees for the selected month.') }}
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Payroll Month') }}</label>
                        <input type="month"
                               name="month"
                               class="form-control"
                               value="{{ now()->format('Y-m') }}"
                               required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-play"></i> {{ __('Generate') }}
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>