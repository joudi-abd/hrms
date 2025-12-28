<h4>Payroll Report</h4>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Month</th>
            <th>Total Net Salary</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payrollStats as $row)
            <tr>
                <td>{{ $row->month }}</td>
                <td>{{ number_format($row->total, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


<div class="d-flex justify-content-center justify-content-between mt-4">

        <div class="card shadow-sm">
            <div class="card-header">
                <i class=""></i>
                <h5 class="mb-0 fw-bold">
                    Net vs Gross vs Deductions
                </h5>
            </div>
            <div class="card-body">
                <canvas id="payrollTrendChart" width="600" height="400"></canvas>
            </div>
        </div>


        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">
                    Paid vs Unpaid Payrolls
                </h5>
            </div>
            <div class="card-body">
                <canvas id="payrollPaidChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){

    // ===== Net / Gross / Deductions =====
    const trendCtx = document.getElementById('payrollTrendChart');
    if(trendCtx){
        new Chart(trendCtx,{
            type:'bar',
            data:{
                labels:@json($payrollTrend->pluck('month')->map(fn($m)=>\Carbon\Carbon::create()->month($m)->format('F'))),
                datasets:[
                    {
                        label:'Net Salary',
                        data:@json($payrollTrend->pluck('net')),
                        backgroundColor:'#0d6efd'
                    },
                    {
                        label:'Gross Salary',
                        data:@json($payrollTrend->pluck('gross')),
                        backgroundColor:'#198754'
                    },
                    {
                        label:'Deductions',
                        data:@json($payrollTrend->pluck('deductions')),
                        backgroundColor:'#ffc107'
                    }
                ]
            },
            options:{responsive:true, plugins:{legend:{position:'bottom'}}, scales:{y:{beginAtZero:true}}}
        });
    }

    const paidCtx = document.getElementById('payrollPaidChart');
    if(paidCtx){
        new Chart(paidCtx,{
            type:'doughnut',
            data:{
                labels:['Paid','Unpaid'],
                datasets:[{
                    data:@json(array_values($payrollPaidUnpaid)),
                    backgroundColor:['#198754','#dc3545'],
                    borderWidth:2
                }]
            },
            options:{responsive:true, plugins:{legend:{position:'bottom'}}}
        });
    }

});
</script>
@endpush