<h4>Leaves Report</h4>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Status</th>
            <th>Count</th>
        </tr>
    </thead>
    <tbody>
        @foreach($leavesByStats as $status => $count)
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
                <i class="fas fa-leaf"></i>
                {{ __('Leaves Status') }}
            </h5>
        </div>
        <div class="card-body">
            <canvas id="leavesStatsChart" height="400" width="450"></canvas>
        </div>
    </div>
    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-chart-line"></i>
                {{ __('Leave Days Trend') }}
            </h5>
        </div>
        <div class="card-body">
            <canvas id="leavesTrendChart" height="400" width="550"></canvas>
        </div>
    </div>
</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){

    // ===== Doughnut: Leaves Status =====
    const statusCtx = document.getElementById('leavesStatsChart');
    if(statusCtx){
        new Chart(statusCtx,{
            type:'doughnut',
            data:{
                labels:@json($leavesByStats->keys()->map(fn($s)=>ucfirst($s))),
                datasets:[{
                    data:@json($leavesByStats->values()),
                    backgroundColor:['#198754','#dc3545','#ffc107'],
                    borderWidth:2
                }]
            },
            options:{responsive:true, plugins:{legend:{position:'bottom'}}}
        });
    }

    // ===== Line: Leave Days per Month =====
    const trendCtx = document.getElementById('leavesTrendChart');
    if(trendCtx){
        new Chart(trendCtx,{
            type:'line',
            data:{
                labels:@json($leavesTrend->pluck('month')->map(fn($m)=>\Carbon\Carbon::create()->month($m)->format('F'))),
                datasets:[{
                    label:'Approved Leave Days',
                    data:@json($leavesTrend->pluck('days')),
                    borderColor:'#0d6efd',
                    backgroundColor:'rgba(13,110,253,0.2)',
                    tension:0.3,
                    fill:true
                }]
            },
            options:{responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}}}
        });
    }

});
</script>
@endpush