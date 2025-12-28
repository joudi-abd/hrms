<div class="row mt-6">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white border-bottom-0 py-4">
                <h3>{{ __('Leave Requests') }}</h3>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Employee Number') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Leave Type') }}</th>
                            <th>{{ __('From - To') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingLeaves as $leave)
                        <tr>
                            <td>{{ $leave->employee->employee_id }}</td>
                            <td>{{ $leave->employee->name }}</td>
                            <td>{{ $leave->leavetype->name ?? __('N/A') }}</td>
                            <td>{{ $leave->start_date ?? __('N/A') }} - {{ $leave->end_date ?? __('N/A') }}</td>
                            <td>
                                <span class="badge badge-pending">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                            <td class="d-flex justify-content-center gap-2">
                                <form action="{{ route('leave-requests.approve', $leave) }}" method="POST">
                                    @csrf
                                    <button class="action-btn approve"
                                            title="{{ __('Approve') }}"
                                            onclick="return confirm('{{ __('Are you sure?') }}')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                <form action="{{ route('leave-requests.reject', $leave) }}" method="POST">
                                    @csrf
                                    <button class="action-btn reject"
                                            title="{{ __('Reject') }}"
                                            onclick="return confirm('{{ __('Are you sure?') }}')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-6">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white border-bottom-0 py-4">
                <h3>{{ __('Tasks') }}</h3>
            </div>

            <div style="margin:20px;display:flex;gap:10px;flex-wrap:wrap;">
                <button class="task-filter-btn active">
                    {{ __('Total') }} {{ $tasks->count() }}
                </button>
                <button class="task-filter-btn">
                    {{ __('In Process') }} {{ $processingTasks }}
                </button>
                <button class="task-filter-btn">
                    {{ __('Pending') }} {{ $pendingTasks }}
                </button>
                <button class="task-filter-btn">
                    {{ __('Completed') }} {{ $completedTasks }}
                </button>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Department') }}</th>
                            <th>{{ __('Priority') }}</th>
                            <th>{{ __('Due Date') }}</th>
                            <th>{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->department->name }}</td>
                            <td>
                                <span class="badge">
                                    {{ __(ucfirst($task->priority)) }}
                                </span>
                            </td>
                            <td>{{ $task->due_date }}</td>
                            <td>{{ $task->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>