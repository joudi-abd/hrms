<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ ucfirst($active) }} Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #2c3e50;
        }

        .header p {
            margin: 2px 0;
            color: #7f8c8d;
        }

        .kpi-section, .table-section {
            width: 95%;
            margin: 10px auto;
        }

        .kpi-box {
            display: inline-block;
            width: 28%;
            background: #ecf0f1;
            padding: 10px;
            margin: 1%;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .kpi-box h3 {
            margin: 5px 0;
            font-size: 16px;
            color: #34495e;
        }

        .kpi-box p {
            margin: 0;
            font-size: 14px;
            color: #16a085;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #bdc3c7;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #2980b9;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #ecf0f1;
        }

        .footer {
            text-align: center;
            position: fixed;
            bottom: 10px;
            width: 100%;
            font-size: 10px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>{{ ucfirst($active) }} Report</h1>
        <p>Report Date: {{ now()->format('Y-m-d') }}</p>
    </div>

    {{-- KPIs --}}
    <div class="align-center">
        <div class="kpi-section align-center">
            @foreach($kpis as $key => $value)
                <div class="kpi-box">
                    <h3>{{ ucfirst(str_replace('_', ' ', $key)) }}</h3>
                    <p>{{ $value }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Data Tables --}}
    <div class="table-section">
        @if($active === 'attendance' && isset($attendanceStats))
            <h3>Attendance Details</h3>
            <table>
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
        @elseif($active === 'payroll' && isset($payrollStats))
            <h3>Payroll Details</h3>
            <table>
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
                            <td>{{ $row->total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif($active === 'leaves' && isset($leavesByStats))
            <h3>Leave Details</h3>
            <table>
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
        @elseif($active === 'tasks' && isset($tasksStats))
            <h3>Task Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $statuses = ['pending', 'in_progress', 'completed'];
                    @endphp
                    @foreach($statuses as $index => $status)
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $status)) }}</td>
                            <td>{{ $tasksStats[$index] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="footer">
        &copy; {{ now()->year }} SmartTransit EDU. All rights reserved.
    </div>

</body>
</html>