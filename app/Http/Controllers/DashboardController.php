<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalRecords = Record::active()->count();
        $activeSuppliers = Supplier::active()->count();
        $staffMembers = User::where('role_id', 2)->active()->count();
        $monthlyRevenue = Record::active()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_expected_profit');

        // Recent Activity (last 5 actions: records, suppliers, staff)
        $recentRecords = Record::active()->with('supplier')->orderByDesc('created_at')->limit(2)->get()->map(function ($r) {
            return [
                'title' => 'New record created',
                'description' => 'Record #' . $r->record_id . ' for ' . ($r->supplier->supplier_name ?? 'Unknown'),
                'icon' => 'plus',
                'timeAgo' => $r->created_at->diffForHumans(),
            ];
        });
        $recentSuppliers = Supplier::active()->orderByDesc('created_at')->limit(2)->get()->map(function ($s) {
            return [
                'title' => 'Supplier added',
                'description' => $s->supplier_name . ' was added.',
                'icon' => 'plus',
                'timeAgo' => $s->created_at->diffForHumans(),
            ];
        });
        $recentStaff = User::where('role_id', 2)->active()->orderByDesc('created_at')->limit(1)->get()->map(function ($u) {
            return [
                'title' => 'Staff member joined',
                'description' => $u->name . ' joined the team.',
                'icon' => 'check',
                'timeAgo' => $u->created_at->diffForHumans(),
            ];
        });
        $recentActivity = $recentRecords->concat($recentSuppliers)->concat($recentStaff)->sortByDesc('timeAgo')->values()->take(5)->toArray();

        return Inertia::render('Dashboard', [
            'totalRecords' => $totalRecords,
            'activeSuppliers' => $activeSuppliers,
            'staffMembers' => $staffMembers,
            'monthlyRevenue' => $monthlyRevenue,
            'recentActivity' => $recentActivity,
        ]);
    }
}
