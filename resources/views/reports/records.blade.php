<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Records Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .filters {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .filter-item {
            margin-bottom: 5px;
        }
        .summary {
            margin-bottom: 20px;
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .currency {
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Records Report</div>
        <div>Generated on: {{ $generated_at }}</div>
    </div>

    <div class="filters">
        <h3>Applied Filters:</h3>
        <div class="filter-item">
            <strong>Suppliers:</strong> 
            @if(count($filters['suppliers']) > 0)
                {{ implode(', ', $filters['suppliers']) }}
            @else
                All Suppliers
            @endif
        </div>
        <div class="filter-item">
            <strong>Date Range:</strong> 
            @if($filters['date_from'] && $filters['date_to'])
                {{ $filters['date_from'] }} to {{ $filters['date_to'] }}
            @elseif($filters['date_from'])
                From {{ $filters['date_from'] }}
            @elseif($filters['date_to'])
                Until {{ $filters['date_to'] }}
            @else
                All Dates
            @endif
        </div>
    </div>

    <div class="summary">
        <h3>Summary:</h3>
        <div><strong>Total Records:</strong> {{ $total_records }}</div>
        <div><strong>Total Expected Profit:</strong> <span class="currency">KSh {{ number_format($total_profit, 2) }}</span></div>
    </div>

    @if(count($records) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Supplier</th>
                    <th>Date Created</th>
                    <th>Total Lorry Amount</th>
                    <th>Total Lorry Units</th>
                    <th>Total Tractor Amount</th>
                    <th>Total Tractor Units</th>
                    <th>Total Expected Profit (Lorry)</th>
                    <th>Total Expected Profit (Tractor)</th>
                    <th>Total Expected Profit</th>
                    <th>Total Confirmed m³</th>
                    <th>Total Extra Cubic</th>
                    <th>Total Less Cubic</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr>
                    <td>{{ $record['id'] }}</td>
                    <td>{{ $record['supplier_name'] }}</td>
                    <td>{{ $record['created_at'] }}</td>
                    <td class="text-right currency">KSh {{ number_format($record['lorry_amount'], 2) }}</td>
                    <td class="text-right">{{ number_format($record['lorry_units'], 2) }} m³</td>
                    <td class="text-right currency">KSh {{ number_format($record['tractor_amount'], 2) }}</td>
                    <td class="text-right">{{ number_format($record['tractor_units'], 2) }} m³</td>
                    <td class="text-right currency">KSh {{ number_format($record['expected_profit_lorry'], 2) }}</td>
                    <td class="text-right currency">KSh {{ number_format($record['expected_profit_tractor'], 2) }}</td>
                    <td class="text-right currency">KSh {{ number_format($record['total_expected_profit'], 2) }}</td>
                    <td class="text-right">{{ number_format($record['confirmed_cubic_meters'], 2) }} m³</td>
                    <td class="text-right">{{ number_format($record['extra_cubic'], 2) }} m³</td>
                    <td class="text-right">{{ number_format($record['less_cubic'], 2) }} m³</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #87CEEB; font-weight: bold; border: 2px solid #333;">
                    <td colspan="3" class="text-right" style="font-size: 14px;">GRAND TOTALS:</td>
                    <td class="text-right currency">KSh {{ number_format(collect($records)->sum('lorry_amount'), 2) }}</td>
                    <td class="text-right">{{ number_format(collect($records)->sum('lorry_units'), 2) }} m³</td>
                    <td class="text-right currency">KSh {{ number_format(collect($records)->sum('tractor_amount'), 2) }}</td>
                    <td class="text-right">{{ number_format(collect($records)->sum('tractor_units'), 2) }} m³</td>
                    <td class="text-right currency">KSh {{ number_format(collect($records)->sum('expected_profit_lorry'), 2) }}</td>
                    <td class="text-right currency">KSh {{ number_format(collect($records)->sum('expected_profit_tractor'), 2) }}</td>
                    <td class="text-right currency">KSh {{ number_format($total_profit, 2) }}</td>
                    <td class="text-right">{{ number_format(collect($records)->sum('confirmed_cubic_meters'), 2) }} m³</td>
                    <td class="text-right">{{ number_format(collect($records)->sum('extra_cubic'), 2) }} m³</td>
                    <td class="text-right">{{ number_format(collect($records)->sum('less_cubic'), 2) }} m³</td>
                </tr>
            </tfoot>
        </table>
    @else
        <div style="text-align: center; padding: 40px; color: #666;">
            <h3>No records found for the selected filters.</h3>
        </div>
    @endif

    <div class="footer">
        <div>This report was automatically generated by the Records Management System</div>
        <div>Page 1 of 1</div>
    </div>
</body>
</html>
