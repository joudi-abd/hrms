@extends('layouts.app')
@section('title','Payrolls')
@section('content')
<div class="container-fluid px-6 py-4">
    <x-flash-message />
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div>
                <div class="border-bottom pb-4">
                    <div class="mb-2 mb-lg-0 d-flex justify-content-between align-items-center">
                        <h1 class="mb-0 fw-bold">{{__('Payrolls')}}</h1>
                        <div class="d-flex">
                            @can('genrate' , App\Models\Payroll::class)
                                <button class="btn btn-primary ms-3 py-2" {{ $monthCreated ? 'disabled' : '' }} data-bs-toggle="modal" data-bs-target="#generatePayrollModal">
                                    <h4 class="mb-0 text-white">
                                        <i class="fa-solid fa-file-invoice-dollar me-3"></i>{{__('Generate Payrolls')}}
                                    </h4>
                                </button>
                            @endcan 
                            @can('pay' , $payrolls->first())
                                <button class="btn btn-success ms-3 py-2" {{ $allPaid ? 'disabled' : '' }} data-bs-toggle="modal" data-bs-target="#payAllModal">
                                    <h4 class="mb-0 text-white">
                                        <i class="fa-solid fa-cash-register me-3"></i>{{__('Pay All Unpaid Payrolls')}}
                                    </h4>
                                </button>
                            @endcan
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="py-6">
        <div class="row mb-6">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div id="hoverable-rows" class="mb-4">
                    <form action="{{ URL::current() }}" method="get" class="row g-3 align-items-end m-2 mt-3">
                        @can('viewAll' , App\Models\Payroll::class)
                            <div class="col-md-3">
                                <x-form.input name="name" placeholder="{{__('Enter name')}}" type="text" label="{{__('Employee Name')}}"
                                        :value="request('name')" />
                            </div>
                        @endcan
                        <div class="col-md-3">
                            <x-form.input name="payroll_month" placeholder="{{__('Select month')}}" type="month" label="{{__('Month')}}"
                                    :value="request('payroll_month')" />
                        </div>
                        <div class="col-md-3">
                            <x-form.select name="status" label="{{__('Payment Status') }}" id="status" for="status" :options="['' => __('All') , 'paid' => __('Paid'), 'unpaid' => __('Unpaid')]" :selected="request('status')" />
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary mx-2"><i class="bi bi-filter me-1"></i>{{__('Filter')}}</button>
                            <button type="button" class="btn btn-secondary" id="resetBtn"><i class="fa fa-arrow-rotate-left me-1"></i>{{__('Reset')}}</button>
                        </div>
                    </form>
                </div>
                <div class="card row">
                    <div class="tab-content p-4" id="pills-tabContent-hoverable-rows">
                        <div class="tab-pane tab-example-design fade show active" id="pills-hoverable-rows-design"
                            role="tabpanel" aria-labelledby="pills-hoverable-rows-design-tab">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('Employee') }}</th>
                                            <th>{{ __('Dep') }}</th>
                                            <th>{{ __('Month') }}</th>
                                            <th>{{ __('Gross') }}</th>
                                            <th>{{ __('Deductions') }}</th>
                                            <th>{{ __('Bonuses') }}</th>
                                            <th>{{ __('Net') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th class="text-center">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($payrolls as $payroll)
                                            <tr>
                                                <td>{{ $payroll->employee->name }}</td>
                                                <td>{{ $payroll->employee->department->name ?? '-' }}</td>
                                                <td>{{ $payroll->payroll_month->format('F Y') }}</td>
                                                <td>{{ number_format($payroll->gross_salary, 2) }}</td>
                                                <td class="text-danger">
                                                    {{ number_format($payroll->deductions, 2) }}
                                                </td>
                                                <td class="text-success">
                                                    {{ number_format($payroll->bonuses, 2) }}
                                                </td>
                                                <td class="fw-bold">
                                                    {{ number_format($payroll->net_salary, 2) }}
                                                </td>
                                                <td>
                                                    @if ($payroll->date_paid)
                                                        <span class="badge bg-success">
                                                            {{ __('Paid') }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            {{ __('Unpaid') }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <!-- @can('view', $payroll)
                                                            <a href="{{ route('payrolls.show', $payroll) }}"
                                                            class="btn btn-sm btn-info">{{ __('View') }}</a>
                                                        @endcan -->
                                                        @can('pay', $payroll)
                                                            @if(!$payroll->date_paid)
                                                                <button class="action-btn pay me-1" title="pay"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#payPayrollModal{{ $payroll->id }}">
                                                                    <i class="fas fa-cash-register"></i>
                                                                </button>
                                                            @endif
                                                        @endcan
                                                        @can('update', $payroll)
                                                            <a href="{{ route('payrolls.edit', $payroll) }}"
                                                            class="action-btn edit me-1" title="edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @endcan
                                                        @can('delete', $payroll)
                                                            <button type="button" class="action-btn delete" title="delete"
                                                             data-bs-target="#deleteModal" 
                                                             data-bs-toggle="modal" 
                                                             data-action="{{ route('payrolls.destroy', $payroll->id)}}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                            @can('pay', $payroll)
                                                @include('payrolls.pay', ['payroll' => $payroll])
                                            @endcan

                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-4">
                                                    {{ __('No payroll records found.') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $payrolls->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{__('Confirm Delete')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{__('Are you sure you want to delete this payroll record?')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{__('Delete')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Generate Payroll Modal --}}
@can('generate', App\Models\Payroll::class)
    @include('payrolls.generate')
@endcan

@endsection

@push('scripts')
    <script>
        document.getElementById('resetBtn').addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = "{{ route('payrolls.index') }}";
        });
    </script>
    <script>
        const deleteModal = document.getElementById('deleteModal');

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const action = button.getAttribute('data-action');
            const form = deleteModal.querySelector('#deleteForm');
            form.action = action;
        });
    </script>
@endpush