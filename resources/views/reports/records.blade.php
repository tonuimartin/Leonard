<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Records Report</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }
        .filters {
            margin-bottom: 15px;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            font-size: 8px;
        }
        .filter-item {
            margin-bottom: 3px;
        }
        .summary {
            margin-bottom: 15px;
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            font-size: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 4px 2px;
            text-align: left;
            font-size: 8px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 7px;
        }
        .text-right {
            text-align: right;
        }
        .bold-numbers {
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .currency {
            font-family: monospace;
            font-size: 7px;
        }
        /* Column widths to fit all data */
        .col-id { width: 4%; }
        .col-supplier { width: 12%; }
        .col-date { width: 8%; }
        .col-amount { width: 8%; }
        .col-units { width: 6%; }
        .col-profit { width: 8%; }
        .col-cubic { width: 6%; }
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
        <div><strong>Total Records:</strong> <span class="bold-numbers">{{ $total_records }}</span></div>
        <div><strong>Total Expected Profit:</strong> <span class="currency bold-numbers">KSh {{ number_format($total_profit, 2) }}</span></div>
    </div>

    @if(count($records) > 0)
        <table>
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-supplier">Supplier</th>
                    <th class="col-date">Date</th>
                    <th class="col-amount">Lorry Amt</th>
                    <th class="col-units">Lorry m³</th>
                    <th class="col-amount">Tractor Amt</th>
                    <th class="col-units">Tractor m³</th>
                    <th class="col-profit">Lorry Profit</th>
                    <th class="col-profit">Tractor Profit</th>
                    <th class="col-profit">Total Profit</th>
                    <th class="col-cubic">Confirmed m³</th>
                    <th class="col-cubic">Extra m³</th>
                    <th class="col-cubic">Less m³</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr>
                    <td class="col-id bold-numbers">{{ $record['id'] }}</td>
                    <td class="col-supplier">{{ substr($record['supplier_name'], 0, 15) }}{{ strlen($record['supplier_name']) > 15 ? '...' : '' }}</td>
                    <td class="col-date">{{ date('m/d/Y', strtotime($record['created_at'])) }}</td>
                    <td class="text-right currency col-amount bold-numbers">{{ number_format($record['lorry_amount'], 0) }}</td>
                    <td class="text-right col-units bold-numbers">{{ number_format($record['lorry_units'], 1) }}</td>
                    <td class="text-right currency col-amount bold-numbers">{{ number_format($record['tractor_amount'], 0) }}</td>
                    <td class="text-right col-units bold-numbers">{{ number_format($record['tractor_units'], 1) }}</td>
                    <td class="text-right currency col-profit bold-numbers">{{ number_format($record['expected_profit_lorry'], 0) }}</td>
                    <td class="text-right currency col-profit bold-numbers">{{ number_format($record['expected_profit_tractor'], 0) }}</td>
                    <td class="text-right currency col-profit bold-numbers">{{ number_format($record['total_expected_profit'], 0) }}</td>
                    <td class="text-right col-cubic bold-numbers">{{ number_format($record['confirmed_cubic_meters'], 1) }}</td>
                    <td class="text-right col-cubic bold-numbers">{{ number_format($record['extra_cubic'], 1) }}</td>
                    <td class="text-right col-cubic bold-numbers">{{ number_format($record['less_cubic'], 1) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #87CEEB; font-weight: bold; border: 2px solid #333;">
                    <td colspan="3" class="text-right bold-numbers" style="font-size: 9px; font-weight: bold;">TOTALS:</td>
                    <td class="text-right currency col-amount bold-numbers">{{ number_format(collect($records)->sum('lorry_amount'), 0) }}</td>
                    <td class="text-right col-units bold-numbers">{{ number_format(collect($records)->sum('lorry_units'), 1) }}</td>
                    <td class="text-right currency col-amount bold-numbers">{{ number_format(collect($records)->sum('tractor_amount'), 0) }}</td>
                    <td class="text-right col-units bold-numbers">{{ number_format(collect($records)->sum('tractor_units'), 1) }}</td>
                    <td class="text-right currency col-profit bold-numbers">{{ number_format(collect($records)->sum('expected_profit_lorry'), 0) }}</td>
                    <td class="text-right currency col-profit bold-numbers">{{ number_format(collect($records)->sum('expected_profit_tractor'), 0) }}</td>
                    <td class="text-right currency col-profit bold-numbers">{{ number_format($total_profit, 0) }}</td>
                    <td class="text-right col-cubic bold-numbers">{{ number_format(collect($records)->sum('confirmed_cubic_meters'), 1) }}</td>
                    <td class="text-right col-cubic bold-numbers">{{ number_format(collect($records)->sum('extra_cubic'), 1) }}</td>
                    <td class="text-right col-cubic bold-numbers">{{ number_format(collect($records)->sum('less_cubic'), 1) }}</td>
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
