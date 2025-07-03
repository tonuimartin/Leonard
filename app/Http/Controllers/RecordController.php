<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RecordController extends Controller
{
    // Show the records view (for Inertia/Vue)
    public function showRecordsView()
    {
        $records = Record::active()
            ->with('supplier')
            ->get()
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
                ];
            })
            ->toArray();

        // Get suppliers for the dropdown in create modal
        $suppliers = Supplier::active()
            ->select('supplier_id', 'supplier_name')
            ->get()
            ->map(function ($supplier) {
                return [
                    'id' => $supplier->supplier_id,
                    'name' => $supplier->supplier_name,
                ];
            })
            ->toArray();

        return Inertia::render('AdminRecordsViewModal', [
            'records' => $records,
            'suppliers' => $suppliers
        ]);
    }

    // Create a new record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'lorry_units' => 'nullable|numeric|min:0',
            'tractor_units' => 'nullable|numeric|min:0',
            'expected_profit_lorry' => 'nullable|numeric|min:0',
            'expected_profit_tractor' => 'nullable|numeric|min:0',
            'total_expected_profit' => 'nullable|numeric|min:0',
            'confirmed_cubic_meters' => 'nullable|numeric|min:0',
            'extra_cubic' => 'nullable|numeric|min:0',
            'less_cubic' => 'nullable|numeric|min:0',
        ]);

        // Calculate amounts based on units (frontend handles the complex calculation logic)
        $lorryUnits = $validated['lorry_units'] ?? 0;
        $tractorUnits = $validated['tractor_units'] ?? 0;

        $lorryAmount = $lorryUnits * Record::LORRY_BUYING_PRICE;
        $tractorAmount = $tractorUnits * Record::TRACTOR_BUYING_PRICE;

        Record::create([
            'supplier_id' => $validated['supplier_id'],
            'lorry_amount' => $lorryAmount,
            'lorry_units' => $lorryUnits,
            'tractor_amount' => $tractorAmount,
            'tractor_units' => $tractorUnits,
            'expected_profit_lorry' => $validated['expected_profit_lorry'] ?? 0,
            'expected_profit_tractor' => $validated['expected_profit_tractor'] ?? 0,
            'total_expected_profit' => $validated['total_expected_profit'] ?? 0,
            'confirmed_cubic_meters' => $validated['confirmed_cubic_meters'] ?? 0,
            'extra_cubic' => $validated['extra_cubic'] ?? 0,
            'less_cubic' => $validated['less_cubic'] ?? 0,
            'deleted' => 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Record created successfully.']);
    }

    // Update a record
    public function update(Request $request, $id)
    {
        $record = Record::where('record_id', $id)->firstOrFail();

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'lorry_units' => 'nullable|numeric|min:0',
            'tractor_units' => 'nullable|numeric|min:0',
            'expected_profit_lorry' => 'nullable|numeric|min:0',
            'expected_profit_tractor' => 'nullable|numeric|min:0',
            'total_expected_profit' => 'nullable|numeric|min:0',
            'confirmed_cubic_meters' => 'nullable|numeric|min:0',
            'extra_cubic' => 'nullable|numeric|min:0',
            'less_cubic' => 'nullable|numeric|min:0',
        ]);

        // Calculate amounts based on units (frontend handles the complex calculation logic)
        $lorryUnits = $validated['lorry_units'] ?? 0;
        $tractorUnits = $validated['tractor_units'] ?? 0;

        $lorryAmount = $lorryUnits * Record::LORRY_BUYING_PRICE;
        $tractorAmount = $tractorUnits * Record::TRACTOR_BUYING_PRICE;

        $record->update([
            'supplier_id' => $validated['supplier_id'],
            'lorry_amount' => $lorryAmount,
            'lorry_units' => $lorryUnits,
            'tractor_amount' => $tractorAmount,
            'tractor_units' => $tractorUnits,
            'expected_profit_lorry' => $validated['expected_profit_lorry'] ?? 0,
            'expected_profit_tractor' => $validated['expected_profit_tractor'] ?? 0,
            'total_expected_profit' => $validated['total_expected_profit'] ?? 0,
            'confirmed_cubic_meters' => $validated['confirmed_cubic_meters'] ?? 0,
            'extra_cubic' => $validated['extra_cubic'] ?? 0,
            'less_cubic' => $validated['less_cubic'] ?? 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Record updated successfully.']);
    }

    // Soft delete a record
    public function destroy($id)
    {
        $record = Record::where('record_id', $id)->firstOrFail();
        $record->softDelete();

        return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);
    }
}
