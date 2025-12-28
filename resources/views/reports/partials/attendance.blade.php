<h4>Attendance Report</h4>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Status</th>
            <th>Count</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendanceStats as $row)
            <tr>
                <td>{{ ucfirst($row->status) }}</td>
                <td>{{ $row->count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center justify-content-between mt-4">

    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-tasks"></i>
                {{ __('Attendance Status Overview') }}
            </h5>
        </div>
        <div class="card-body">
            <canvas id="attendanceChart" height="400" width="450"></canvas>
        </div>
    
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-chart-line"></i>
                {{ __('Attendance Trend') }}
            </h5>
        </div>
        <div class="card-body">
            <canvas id="attendanceTrendChart" height="400" width="550"></canvas>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){

    const attendanceCtx = document.getElementById('attendanceChart');
    if(attendanceCtx){
        new Chart(attendanceCtx,{
            type:'doughnut',
            data:{
                labels:@json($attendanceStats->pluck('status')),
                datasets:[{
                    data:@json($attendanceStats->pluck('count')),
                    backgroundColor:['#9cda9e','#ffad96','#6d6d6d']
                }]
            }
        });
    }

    const trendCtx = document.getElementById('attendanceTrendChart');
    if(trendCtx){
        new Chart(trendCtx,{
            type:'line',
            data:{
                labels:@json($attendanceTrend->pluck('day')),
                datasets:[{
                    data:@json($attendanceTrend->pluck('count')),
                    borderColor:'#0d6efd',
                    fill:true
                }]
            },
            options:{
                responsive:true,
                scales:{
                    y:{
                        beginAtZero:true,
                        grace:'20%'
                    }
                }
            }
        });
    }

});
</script>
@endpush