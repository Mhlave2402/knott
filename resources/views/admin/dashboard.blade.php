@extends('layouts.admin')

@section('title', 'Admin Dashboard - Knott')

@push('styles')
<style>
    .metric-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .metric-card.revenue {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .metric-card.vendors {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .metric-card.gift-well {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header with real-time stats -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Admin Dashboard
                </h1>
                <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm text-gray-500">Platform Growth</p>
                    <p class="text-lg font-semibold {{ $metrics['platform_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($metrics['platform_growth'], 1) }}%
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Conversion Rate</p>
                    <p class="text-lg font-semibold text-blue-600">
                        {{ number_format($metrics['conversion_rate'], 1) }}%
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="p-6 space-y-8">
        <!-- Enhanced Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="metric-card rounded-xl p-6 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <span class="text-sm opacity-90">Total Users</span>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-bold">{{ number_format($metrics['total_users']) }}</p>
                        <div class="flex items-center text-sm opacity-90">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span>+12% this month</span>
                        </div>
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full transform translate-x-16 -translate-y-8"></div>
            </div>

            <div class="metric-card revenue rounded-xl p-6 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <span class="text-sm opacity-90">Monthly Revenue</span>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-bold">R{{ number_format($metrics['monthly_revenue'], 0) }}</p>
                        <div class="flex items-center text-sm opacity-90">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span>+23% vs last month</span>
                        </div>
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full transform translate-x-16 -translate-y-8"></div>
            </div>

            <div class="metric-card vendors rounded-xl p-6 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span class="text-sm opacity-90">Active Vendors</span>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-bold">{{ number_format($metrics['total_vendors']) }}</p>
                        <div class="flex items-center text-sm opacity-90">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span>{{ $metrics['vendor_subscriptions'] }} subscribed</span>
                        </div>
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full transform translate-x-16 -translate-y-8"></div>
            </div>

            <div class="metric-card gift-well rounded-xl p-6 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                            </svg>
                        </div>
                        <span class="text-sm opacity-90">Gift Well Volume</span>
                    </div>
                    <div class="space-y-1">
                        <p class="text-3xl font-bold">R{{ number_format($metrics['gift_well_volume'], 0) }}</p>
                        <div class="flex items-center text-sm opacity-90">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            <span>+35% vs last month</span>
                        </div>
                    </div>
                </div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full transform translate-x-16 -translate-y-8"></div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Revenue Analytics</h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg" onclick="updateChart('7days')">7D</button>
                            <button class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-lg" onclick="updateChart('30days')">30D</button>
                            <button class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-lg" onclick="updateChart('90days')">90D</button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Top Performing Vendors</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($topVendors->take(5) as $index => $vendor)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                    <span class="text-sm font-semibold text-blue-600">#{{ $index + 1 }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $vendor->business_name ?? $vendor->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $vendor->total_bookings }} bookings</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">R{{ number_format($vendor->total_revenue ?? 0, 0) }}</p>
                                <div class="flex items-center justify-end">
                                    <span class="text-yellow-400 text-sm">★</span>
                                    <span class="text-sm text-gray-600 ml-1">{{ number_format($vendor->avg_rating ?? 0, 1) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Items & Alerts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.102 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Priority Actions
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    @if($pendingApplications > 0)
                    <div class="flex items-center justify-between p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div>
                            <p class="font-medium text-yellow-800">Vendor Applications Pending</p>
                            <p class="text-sm text-yellow-600">{{ $pendingApplications }} applications need review</p>
                        </div>
                        <a href="{{ route('admin.vendor-approvals.index') }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                            Review
                        </a>
                    </div>
                    @endif

                    @if($activeDisputes > 0)
                    <div class="flex items-center justify-between p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div>
                            <p class="font-medium text-red-800">Active Disputes</p>
                            <p class="text-sm text-red-600">{{ $activeDisputes }} disputes require attention</p>
                        </div>
                        <a href="{{ route('admin.disputes.index') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Handle
                        </a>
                    </div>
                    @endif

                    @if($competitionEntries > 0)
                    <div class="flex items-center justify-between p-4 bg-purple-50 border border-purple-200 rounded-lg">
                        <div>
                            <p class="font-medium text-purple-800">Competition Entries</p>
                            <p class="text-sm text-purple-600">{{ $competitionEntries }} entries to judge</p>
                        </div>
                        <a href="{{ route('admin.competitions.index') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            Judge
                        </a>
                    </div>
                    @endif

                    @if($pendingApplications === 0 && $activeDisputes === 0 && $competitionEntries === 0)
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-green-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-600">All caught up! No urgent actions needed.</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">System Health</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                            <span class="text-gray-700">Database</span>
                        </div>
                        <span class="text-green-600 font-medium">Healthy</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                            <span class="text-gray-700">Payment Gateway</span>
                        </div>
                        <span class="text-green-600 font-medium">Online</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                            <span class="text-gray-700">AI Matching Service</span>
                        </div>
                        <span class="text-green-600 font-medium">Active</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3"></div>
                            <span class="text-gray-700">Email Service</span>
                        </div>
                        <span class="text-yellow-600 font-medium">Slow</span>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">Server Load</span>
                            <span class="text-sm font-medium text-gray-900">23%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-400 h-2 rounded-full" style="width: 23%"></div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">Storage Usage</span>
                            <span class="text-sm font-medium text-gray-900">67%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-400 h-2 rounded-full" style="width: 67%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg p-4 border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $metrics['active_bookings'] }}</p>
                        <p class="text-sm text-gray-600">Active Bookings</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $metrics['total_couples'] }}</p>
                        <p class="text-sm text-gray-600">Couples Registered</p>
                    </div>
                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">4.8</p>
                        <p class="text-sm text-gray-600">Avg Platform Rating</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 border">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($metrics['conversion_rate'], 1) }}%</p>
                        <p class="text-sm text-gray-600">Quote Conversion</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let revenueChart;

// Initialize chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($revenueChart->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('M d'))),
            datasets: [{
                label: 'Daily Revenue',
                data: @json($revenueChart->pluck('revenue')),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: R' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'R' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});

// Update chart function
function updateChart(period) {
    // Update button states
    document.querySelectorAll('[onclick^="updateChart"]').forEach(btn => {
        btn.className = 'px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-lg';
    });
    event.target.className = 'px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-lg';
    
    // Fetch new data
    fetch(`/admin/api/revenue-chart?period=${period}`)
        .then(response => response.json())
        .then(data => {
            revenueChart.data.labels = data.labels;
            revenueChart.data.datasets[0].data = data.values;
            revenueChart.update();
        });
}

// Real-time updates every 30 seconds
setInterval(function() {
    fetch('/admin/api/dashboard-metrics')
        .then(response => response.json())
        .then(data => {
            // Update metrics without full page reload
            document.querySelector('[data-metric="users"]').textContent = data.total_users.toLocaleString();
            document.querySelector('[data-metric="revenue"]').textContent = 'R' + data.monthly_revenue.toLocaleString();
            document.querySelector('[data-metric="vendors"]').textContent = data.total_vendors.toLocaleString();
            document.querySelector('[data-metric="gift_well"]').textContent = 'R' + data.gift_well_volume.toLocaleString();
        });
}, 30000);
</script>
@endpush
@endsection
