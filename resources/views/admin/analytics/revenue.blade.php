@extends('layouts.dashboard')

@section('title', 'Revenue Analytics')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Revenue Analytics</h1>
            <p class="text-gray-600">Track platform revenue and financial performance</p>
        </div>

        <!-- Revenue Overview Cards -->
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">R{{ number_format($analytics['total_revenue']) }}</p>
                        <p class="text-xs text-green-600">+{{ $analytics['revenue_growth'] }}% this month</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Subscription Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">R{{ number_format($analytics['subscription_revenue']) }}</p>
                        <p class="text-xs text-gray-500">{{ $analytics['active_subscriptions'] }} active subscriptions</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A2.704 2.704 0 004.5 16c-.523 0-1.046-.151-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Gift Well Fees</p>
                        <p class="text-2xl font-bold text-gray-900">R{{ number_format($analytics['gift_well_fees']) }}</p>
                        <p class="text-xs text-gray-500">{{ $analytics['total_contributions'] }} contributions processed</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Booking Commissions</p>
                        <p class="text-2xl font-bold text-gray-900">R{{ number_format($analytics['booking_commissions']) }}</p>
                        <p class="text-xs text-gray-500">{{ $analytics['total_bookings'] }} bookings processed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Charts -->
        <div class="grid lg:grid-cols-2 gap-8 mb-8">
            <!-- Monthly Revenue Trend -->
            <div class="bg-white rounded-xl shadow-sm p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Monthly Revenue Trend</h2>
                <canvas id="revenue-chart" width="400" height="200"></canvas>
            </div>

            <!-- Revenue Sources -->
            <div class="bg-white rounded-xl shadow-sm p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Revenue Sources</h2>
                <canvas id="sources-chart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Detailed Revenue Table -->
        <div class="bg-white rounded-xl shadow-sm p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-900">Revenue Breakdown</h2>
                <div class="flex space-x-2">
                    <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option>This Month</option>
                        <option>Last Month</option>
                        <option>Last 3 Months</option>
                        <option>This Year</option>
                    </select>
                    <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Export Report
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue Source</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction Count</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Growth</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($analytics['revenue_breakdown'] as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['date'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['source'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">R{{ number_format($item['amount']) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item['count'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($item['growth'] > 0)
                                <span class="text-green-600 font-semibold">+{{ $item['growth'] }}%</span>
                                @elseif($item['growth'] < 0)
                                <span class="text-red-600 font-semibold">{{ $item['growth'] }}%</span>
                                @else
                                <span class="text-gray-500">0%</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Trend Chart
    const revenueCtx = document.getElementById('revenue-chart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($analytics['monthly_labels']) !!},
            datasets: [{
                label: 'Total Revenue',
                data: {!! json_encode($analytics['monthly_revenue']) !!},
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Revenue Sources Chart
    const sourcesCtx = document.getElementById('sources-chart').getContext('2d');
    new Chart(sourcesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Subscriptions', 'Gift Well Fees', 'Booking Commissions', 'Featured Listings'],
            datasets: [{
                data: [
                    {{ $analytics['subscription_revenue'] }},
                    {{ $analytics['gift_well_fees'] }},
                    {{ $analytics['booking_commissions'] }},
                    {{ $analytics['featured_revenue'] }}
                ],
                backgroundColor: ['#8B5CF6', '#EC4899', '#10B981', '#F59E0B']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection