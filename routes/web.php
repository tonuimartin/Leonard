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
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Staff routes
    Route::get('/staff', [\App\Http\Controllers\StaffController::class, 'showStaffView'])->name('staff.view');
    Route::post('/staff', [\App\Http\Controllers\StaffController::class, 'store'])->name('staff.store');
    Route::put('/staff/{id}', [\App\Http\Controllers\StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{id}', [\App\Http\Controllers\StaffController::class, 'destroy'])->name('staff.destroy');

    // Supplier routes
    Route::get('/supplier', [\App\Http\Controllers\SupplierController::class, 'showSupplierView'])->name('supplier.view');
    Route::post('/supplier', [\App\Http\Controllers\SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/supplier/{id}', [\App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{id}', [\App\Http\Controllers\SupplierController::class, 'destroy'])->name('supplier.destroy');

    // Record routes
    Route::get('/records', [\App\Http\Controllers\RecordController::class, 'showRecordsView'])->name('records.view');
    Route::post('/records', [\App\Http\Controllers\RecordController::class, 'store'])->name('records.store');
    Route::put('/records/{id}', [\App\Http\Controllers\RecordController::class, 'update'])->name('records.update');
    Route::delete('/records/{id}', [\App\Http\Controllers\RecordController::class, 'destroy'])->name('records.destroy');

    // Report routes
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'showReportsView'])->name('reports.view');
    Route::post('/reports/check', [\App\Http\Controllers\ReportController::class, 'checkRecords'])->name('reports.check');
    Route::post('/reports/pdf', [\App\Http\Controllers\ReportController::class, 'downloadPDF'])->name('reports.pdf');
    Route::post('/reports/excel', [\App\Http\Controllers\ReportController::class, 'downloadExcel'])->name('reports.excel');
});

require __DIR__ . '/auth.php';
