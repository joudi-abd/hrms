<h4 class="fw-bold">Tasks Report</h4>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Status</th>
            <th>Count</th>
        </tr>
    </thead>
    <tbody>
        @foreach($taskData as $status => $count)
            <tr>
                <td>{{ ucfirst($status) }}</td>
                <td>{{ $count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center justify-content-between mt-4">
    
    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-tasks"></i>
                {{ __('Tasks Status Overview') }}
            </h5>
        </div>
        <div class="card-body">
            <canvas id="tasksChart" height="400" width="450"></canvas>
        </div>

    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-building"></i>
                {{ __('Completed Tasks by Department') }}
            </h5>
        </div>
        <div class="card-body">
            <canvas id="departmentTasksChart" height="450" width="550"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){

    const tasksCtx = document.getElementById('tasksChart');
    if(tasksCtx){
        new Chart(tasksCtx,{
            type:'doughnut',
            data:{
                labels:['Pending','In Progress','Completed'],
                datasets:[{
                    data:@json($tasksStats),
                    backgroundColor:['#ffc107','#0d6efd','#198754']
                }]
            }
        });
    }

    const deptCtx = document.getElementById('departmentTasksChart');
    if(deptCtx){
        new Chart(deptCtx,{
            type:'bar',
            data:{
                labels:@json($departmentLabels),
                datasets:[{
                    data:@json($departmentCompletedTasks),
                    backgroundColor:'#3c79d2'
                }]
            },
            options:{
                plugins:{legend:{display:false}},
                responsive:true,
                scales:{
                    y:{
                        beginAtZero:true,
                        stepSize:5

                    }
                }
            }
        });
    }

});
</script>
@endpush
