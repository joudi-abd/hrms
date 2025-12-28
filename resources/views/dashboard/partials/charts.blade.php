<div class="row mt-6">
    <div class="col-xl-6 col-md-12">
        <div class="card">
            <div class="card-header bg-white border-bottom-0 py-4">
                <h3>{{ __('Monthly Attendance') }}</h3>
            </div>
            <div class="card-body">
                <div id="attendanceChart"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-12">
        <div class="card">
            <div class="card-header bg-white border-bottom-0 py-4">
                <h3>{{ __('Monthly Payrolls') }}</h3>
            </div>
            <div class="card-body">
                <div id="payrollChart"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
var attendanceChart = new ApexCharts(document.querySelector("#attendanceChart"), {
    chart: { type: 'bar', height: 350 },
    series: [
        { name: "{{ __('Present') }}", data: @json($monthlyPresent) },
        { name: "{{ __('Absent') }}", data: @json($monthlyAbsent) }
    ],
    xaxis: { categories: @json($months) }
});
attendanceChart.render();

var payrollChart = new ApexCharts(document.querySelector("#payrollChart"), {
    chart: { type: 'line', height: 350 },
    series: [
        { name: "{{ __('Payrolls') }}", data: @json($monthlyPayroll) }
    ],
    xaxis: { categories: @json($months) }
});
payrollChart.render();
</script>
@endpush
