<?php

namespace App\Services;

use App\Models\User;
use App\Models\Booking;
use App\Models\GiftWellContribution;
use App\Models\VendorSubscription;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AnalyticsService
{
    public function getDashboardMetrics(): array
    {
        return Cache::remember('admin_dashboard_metrics', now()->addMinutes(15), function () {
            return [
                'total_users' => User::count(),
                'total_vendors' => User::where('role', 'vendor')->count(),
                'total_couples' => User::where('role', 'couple')->count(),
                'active_bookings' => Booking::where('status', 'confirmed')->count(),
                'monthly_revenue' => $this->getMonthlyRevenue(),
                'gift_well_volume' => $this->getGiftWellVolume(),
                'vendor_subscriptions' => $this->getActiveSubscriptions(),
                'platform_growth' => $this->getPlatformGrowth(),
                'conversion_rate' => $this->getConversionRate()
            ];
        });
    }

    public function getRevenueChart(string $period = '30days'): \Illuminate\Support\Collection
    {
        $days = match($period) {
            '7days' => 7,
            '30days' => 30,
            '90days' => 90,
            default => 30
        };

        return Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(platform_fee) as revenue'),
                DB::raw('COUNT(*) as transaction_count')
            )
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function getVendorPerformance(int $limit = 10): \Illuminate\Support\Collection
    {
        return DB::table('users')
            ->join('vendor_profiles', 'users.id', '=', 'vendor_profiles.user_id')
            ->leftJoin('bookings', 'users.id', '=', 'bookings.vendor_id')
            ->leftJoin('reviews', 'users.id', '=', 'reviews.vendor_id')
            ->select(
                'users.id',
                'users.name',
                'vendor_profiles.business_name',
                DB::raw('COUNT(DISTINCT bookings.id) as total_bookings'),
                DB::raw('AVG(reviews.rating) as avg_rating'),
                DB::raw('SUM(bookings.amount) as total_revenue'),
                DB::raw('COUNT(DISTINCT reviews.id) as review_count')
            )
            ->where('users.role', 'vendor')
            ->groupBy('users.id', 'users.name', 'vendor_profiles.business_name')
            ->orderByDesc('total_revenue')
            ->limit($limit)
            ->get();
    }

    public function getDisputeAnalytics(): array
    {
        return [
            'total_disputes' => Dispute::count(),
            'open_disputes' => Dispute::where('status', 'open')->count(),
            'resolved_disputes' => Dispute::where('status', 'resolved')->count(),
            'avg_resolution_time' => $this->getAverageResolutionTime(),
            'disputes_by_category' => $this->getDisputesByCategory()
        ];
    }

    private function getMonthlyRevenue(): float
    {
        return Transaction::where('created_at', '>=', Carbon::now()->startOfMonth())
            ->where('status', 'completed')
            ->sum('platform_fee');
    }

    private function getGiftWellVolume(): float
    {
        return GiftWellContribution::where('created_at', '>=', Carbon::now()->startOfMonth())
            ->sum('amount');
    }

    private function getActiveSubscriptions(): int
    {
        return VendorSubscription::where('status', 'active')
            ->where('expires_at', '>', now())
            ->count();
    }

    private function getPlatformGrowth(): float
    {
        $currentMonth = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $lastMonth = User::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();

        return $lastMonth > 0 ? (($currentMonth - $lastMonth) / $lastMonth) * 100 : 0;
    }

    private function getConversionRate(): float
    {
        $totalQuoteRequests = DB::table('quote_requests')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        $convertedBookings = Booking::where('created_at', '>=', Carbon::now()->startOfMonth())
            ->where('status', 'confirmed')
            ->count();

        return $totalQuoteRequests > 0 ? ($convertedBookings / $totalQuoteRequests) * 100 : 0;
    }

    private function getAverageResolutionTime(): float
    {
        return Dispute::where('status', 'resolved')
            ->whereNotNull('resolved_at')
            ->get()
            ->avg(function ($dispute) {
                return $dispute->created_at->diffInHours($dispute->resolved_at);
            }) ?? 0;
    }

    private function getDisputesByCategory(): \Illuminate\Support\Collection
    {
        return Dispute::select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->get();
    }
}