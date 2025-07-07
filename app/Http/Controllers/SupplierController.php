<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\User;
use App\Notifications\SupplierCreated;
use App\Notifications\SupplierUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

class SupplierController extends Controller
{
    // Fetch all suppliers with role_id = 3 (API endpoint)
    public function index()
    {
        $suppliers = Supplier::where('role_id', 3)
            ->active()
            ->select('supplier_id', 'supplier_name', 'phone_number', 'role_id')
            ->get()
            ->map(function ($supplier) {
                return [
                    'id' => $supplier->supplier_id,
                    'name' => $supplier->supplier_name,
                    'phone_number' => $supplier->phone_number,
                ];
            });
        return response()->json($suppliers);
    }

    // Show the supplier view (for Inertia/Vue)
    public function showSupplierView()
    {
        $suppliers = Supplier::where('role_id', 3)
            ->active()
            ->select('supplier_id', 'supplier_name', 'phone_number', 'role_id')
            ->get()
            ->map(function ($supplier) {
                return [
                    'id' => $supplier->supplier_id,
                    'name' => $supplier->supplier_name,
                    'phone_number' => $supplier->phone_number,
                ];
            })
            ->toArray(); // Ensure it's a plain array

        return Inertia::render('AdminSupplierViewModal', [
            'suppliers' => $suppliers
        ]);
    }

    // Create a new supplier
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $supplier = Supplier::create([
            'supplier_name' => $request->name,
            'phone_number' => $request->phone_number,
            'role_id' => 3, // Supplier role
            'deleted' => 0, // Default to active
        ]);

        // Notify all admins
        $admins = User::where('role_id', 1)->get();
        Notification::send($admins, new SupplierCreated($supplier, auth()->user()));

        // Return the created supplier object for frontend
        return response()->json([
            'id' => $supplier->supplier_id,
            'name' => $supplier->supplier_name,
            'phone_number' => $supplier->phone_number,
        ], 201);
    }    // Soft delete a supplier
    public function destroy($id)
    {
        $supplier = Supplier::where('supplier_id', $id)->firstOrFail();
        $supplier->softDelete(); // This will set deleted = 1

        return response()->json(['success' => true, 'message' => 'Supplier deleted successfully.']);
    }    // Update a supplier
    public function update(Request $request, $id)
    {
        $supplier = Supplier::where('supplier_id', $id)->firstOrFail();

        $oldData = $supplier->getOriginal();

        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $supplier->update([
            'supplier_name' => $validated['supplier_name'],
            'phone_number' => $validated['phone_number'],
        ]);

        // Notify all admins
        $admins = User::where('role_id', 1)->get();
        Notification::send($admins, new SupplierUpdated($supplier, auth()->user(), $oldData));

        return response()->json(['success' => true, 'message' => 'Supplier updated successfully.']);
    }
}
