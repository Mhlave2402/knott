<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use App\Models\VendorApplication;
use App\Models\Dispute;
use App\Models\CompetitionEntry;

class DashboardController extends Controller
{
    public function __construct(private AnalyticsService $analyticsService)
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $metrics = $this->analyticsService->getDashboardMetrics();
        $revenueChart = $this->analyticsService->getRevenueChart();
        $topVendors = $this->analyticsService->getVendorPerformance();
        
        $pendingApplications = VendorApplication::where('status', 'pending')->count();
        $activeDisputes = Dispute::where('status', 'open')->count();
        $competitionEntries = CompetitionEntry::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'metrics',
            'revenueChart',
            'topVendors',
            'pendingApplications',
            'activeDisputes',
            'competitionEntries'
        ));
    }
}
