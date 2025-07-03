<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReportController extends Controller
{
    public function showReportsView()
    {
        // Get all suppliers for the filter dropdown
        $suppliers = Supplier::where('role_id', 3)
            ->active()
            ->select('supplier_id', 'supplier_name')
            ->get()
            ->map(function ($supplier) {
                return [
                    'id' => $supplier->supplier_id,
                    'name' => $supplier->supplier_name,
                ];
            })
            ->toArray();

        // Get all records initially (can be filtered later)
        $records = $this->getFilteredRecords([], null, null);

        return Inertia::render('AdminReportsView', [
            'suppliers' => $suppliers,
            'records' => $records
        ]);
    }

    public function downloadPDF(Request $request)
    {
        $supplierIds = $request->input('supplier_ids', []);
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        // Get filtered records
        $records = $this->getFilteredRecords($supplierIds, $dateFrom, $dateTo);

        // Get supplier names for the report header
        $supplierNames = [];
        if (!empty($supplierIds)) {
            $supplierNames = Supplier::whereIn('supplier_id', $supplierIds)
                ->pluck('supplier_name')
                ->toArray();
        }

        $data = [
            'records' => $records,
            'filters' => [
                'suppliers' => $supplierNames,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ],
            'generated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'total_profit' => collect($records)->sum('total_expected_profit'),
            'total_records' => count($records)
        ];

        $pdf = PDF::loadView('reports.records', $data);

        $filename = 'records_report_' . Carbon::now()->format('Y_m_d_H_i_s') . '.pdf';

        return $pdf->download($filename);
    }

    public function downloadExcel(Request $request)
    {
        $supplierIds = $request->input('supplier_ids', []);
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        // Get filtered records
        $records = $this->getFilteredRecords($supplierIds, $dateFrom, $dateTo);

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header row
        $sheet->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Supplier ID')
            ->setCellValue('C1', 'Supplier Name')
            ->setCellValue('D1', 'Lorry Amount')
            ->setCellValue('E1', 'Lorry Units')
            ->setCellValue('F1', 'Tractor Amount')
            ->setCellValue('G1', 'Tractor Units')
            ->setCellValue('H1', 'Expected Profit (Lorry)')
            ->setCellValue('I1', 'Expected Profit (Tractor)')
            ->setCellValue('J1', 'Total Expected Profit')
            ->setCellValue('K1', 'Confirmed Cubic Meters')
            ->setCellValue('L1', 'Extra Cubic')
            ->setCellValue('M1', 'Less Cubic')
            ->setCellValue('N1', 'Created At')
            ->setCellValue('O1', 'Deleted');

        // Apply header styling
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'CCCCCC'],
            ],
        ];
        $sheet->getStyle('A1:O1')->applyFromArray($headerStyle);

        // Populate the data rows
        $row = 2;
        foreach ($records as $record) {
            $sheet->setCellValue('A' . $row, $record['id'])
                ->setCellValue('B' . $row, $record['supplier_id'])
                ->setCellValue('C' . $row, $record['supplier_name'])
                ->setCellValue('D' . $row, $record['lorry_amount'])
                ->setCellValue('E' . $row, $record['lorry_units'])
                ->setCellValue('F' . $row, $record['tractor_amount'])
                ->setCellValue('G' . $row, $record['tractor_units'])
                ->setCellValue('H' . $row, $record['expected_profit_lorry'])
                ->setCellValue('I' . $row, $record['expected_profit_tractor'])
                ->setCellValue('J' . $row, $record['total_expected_profit'])
                ->setCellValue('K' . $row, $record['confirmed_cubic_meters'])
                ->setCellValue('L' . $row, $record['extra_cubic'])
                ->setCellValue('M' . $row, $record['less_cubic'])
                ->setCellValue('N' . $row, $record['created_at'])
                ->setCellValue('O' . $row, $record['deleted'] ? 'Yes' : 'No');
            $row++;
        }

        // Apply data styling
        $dataStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:O' . ($row - 1))->applyFromArray($dataStyle);

        // Auto-size columns
        foreach (range('A', 'O') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set filename and download
        $filename = 'records_report_' . Carbon::now()->format('Y_m_d_H_i_s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }

    private function getFilteredRecords($supplierIds = [], $dateFrom = null, $dateTo = null)
    {
        $query = Record::active()->with('supplier');

        // Filter by suppliers if provided
        if (!empty($supplierIds)) {
            $query->whereIn('supplier_id', $supplierIds);
        }

        // Filter by date range if provided
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Sort by created_at (newest first)
        $query->orderBy('created_at', 'desc');

        return $query->get()
            ->map(function ($record) {
                return [
                    'id' => $record->record_id,
                    'supplier_id' => $record->supplier_id,
                    'supplier_name' => $record->supplier->supplier_name ?? 'Unknown Supplier',
                    'lorry_amount' => $record->lorry_amount,
                    'lorry_units' => $record->lorry_units,
                    'tractor_amount' => $record->tractor_amount,
                    'tractor_units' => $record->tractor_units,
                    'expected_profit_lorry' => $record->expected_profit_lorry,
                    'expected_profit_tractor' => $record->expected_profit_tractor,
                    'total_expected_profit' => $record->total_expected_profit,
                    'confirmed_cubic_meters' => $record->confirmed_cubic_meters,
                    'extra_cubic' => $record->extra_cubic,
                    'less_cubic' => $record->less_cubic,
                    'created_at' => $record->created_at->format('j F Y'),
                    'deleted' => $record->deleted,
                ];
            })
            ->toArray();
    }
}
