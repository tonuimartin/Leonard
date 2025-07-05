<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'auth' => [
            'user' => auth()->user(),
        ],
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'fully.verified'])->name('dashboard');

// Admin approval routes (accessible without full authentication)
Route::get('/admin/approve-user', [\App\Http\Controllers\AdminApprovalController::class, 'showApprovalPage'])
    ->name('admin.approve-user');
Route::post('/admin/approve-user', [\App\Http\Controllers\AdminApprovalController::class, 'approveUser'])
    ->name('admin.approve-user.confirm');

Route::middleware(['auth', 'fully.verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Supplier routes (all users can view, but only admins can delete)
    Route::get('/supplier', [\App\Http\Controllers\SupplierController::class, 'showSupplierView'])->name('supplier.view');
    Route::post('/supplier', [\App\Http\Controllers\SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/supplier/{id}', [\App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');

    // Record routes (all users can view/create/edit, but only admins can delete)
    Route::get('/records', [\App\Http\Controllers\RecordController::class, 'showRecordsView'])->name('records.view');
    Route::post('/records', [\App\Http\Controllers\RecordController::class, 'store'])->name('records.store');
    Route::put('/records/{id}', [\App\Http\Controllers\RecordController::class, 'update'])->name('records.update');
});

// Admin-only routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Staff routes (admin only)
    Route::get('/staff', [\App\Http\Controllers\StaffController::class, 'showStaffView'])->name('staff.view');
    Route::post('/staff', [\App\Http\Controllers\StaffController::class, 'store'])->name('staff.store');
    Route::put('/staff/{id}', [\App\Http\Controllers\StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{id}', [\App\Http\Controllers\StaffController::class, 'destroy'])->name('staff.destroy');

    // Admin approval routes
    Route::get('/admin/pending-approvals', [\App\Http\Controllers\AdminApprovalController::class, 'showPendingApprovals'])->name('admin.pending-approvals');
    Route::post('/admin/approve-user/{userId}', [\App\Http\Controllers\AdminApprovalController::class, 'approveFromDashboard'])->name('admin.approve-from-dashboard');

    // Supplier delete route (admin only)
    Route::delete('/supplier/{id}', [\App\Http\Controllers\SupplierController::class, 'destroy'])->name('supplier.destroy');

    // Record delete route (admin only)
    Route::delete('/records/{id}', [\App\Http\Controllers\RecordController::class, 'destroy'])->name('records.destroy');

    // Report routes (admin only)
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'showReportsView'])->name('reports.view');
    Route::post('/reports/check', [\App\Http\Controllers\ReportController::class, 'checkRecords'])->name('reports.check');
    Route::post('/reports/pdf', [\App\Http\Controllers\ReportController::class, 'downloadPDF'])->name('reports.pdf');
    Route::post('/reports/excel', [\App\Http\Controllers\ReportController::class, 'downloadExcel'])->name('reports.excel');
});

require __DIR__ . '/auth.php';
