@extends('layouts.dashboard')

@section('title', 'Manage Gift Well')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Actions -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $giftWell->title }}</h1>
                <p class="text-gray-600">Manage your wedding gift well and track contributions</p>
            </div>
            <div class="flex space-x-4">
                <button onclick="copyGiftWellLink()" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Share Link
                </button>
                
                @if($giftWell->wedding_date->isPast() && $giftWell->total_amount > 0 && $giftWell->status === 'active')
                <button onclick="initiateWithdrawal()" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    Withdraw Funds
                </button>
                @endif
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Statistics Cards -->
            <div class="lg:col-span-3 grid md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Raised</p>
                            <p class="text-2xl font-bold text-gray-900">R{{ number_format($giftWell->total_amount) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Contributors</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $statistics['total_contributors'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Average Gift</p>
                            <p class="text-2xl font-bold text-gray-900">R{{ number_format($statistics['average_contribution']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Largest Gift</p>
                            <p class="text-2xl font-bold text-gray-900">R{{ number_format($statistics['largest_contribution']) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Section -->
            @if($giftWell->target_amount)
            <div class="lg:col-span-3 bg-white rounded-xl shadow-sm p-8 mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Progress Towards Goal</h2>
                
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">R{{ number_format($giftWell->total_amount) }} raised</span>
                        <span class="text-sm font-medium text-gray-700">R{{ number_format($giftWell->target_amount) }} goal</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-6">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-6 rounded-full transition-all duration-500 flex items-center justify-end pr-2" 
                             style="width: {{ $giftWell->progress_percentage }}%">
                            <span class="text-white text-sm font-semibold">{{ $giftWell->progress_percentage }}%</span>
                        </div>
                    </div>
                </div>

                @if($giftWell->progress_percentage >= 100)
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-green-800 font-semibold">Congratulations! You've reached your goal!</span>
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Recent Contributions -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-900">Recent Contributions</h2>
                        <a href="{{ route('couples.gift-well.contributions', $giftWell) }}" 
                           class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                            View All
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($statistics['recent_contributions'] as $contribution)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($contribution->display_name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $contribution->display_name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $contribution->paid_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="text-lg font-bold text-green-600">R{{ number_format($contribution->amount) }}</span>
                                </div>
                                @if($contribution->message)
                                <p class="text-gray-700 text-sm mt-2 italic">"{{ $contribution->message }}"</p>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                            </svg>
                            <p class="text-gray-600">No contributions yet</p>
                            <p class="text-sm text-gray-500 mt-1">Share your gift well link to start receiving contributions</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Quick Actions</h2>
                    
                    <div class="space-y-4">
                        <button onclick="copyGiftWellLink()" 
                                class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Copy Share Link
                        </button>
                        
                        <a href="{{ route('guests.gift-well.show', $giftWell) }}" target="_blank"
                           class="w-full flex items-center justify-center px-4 py-3 border border-purple-300 rounded-lg text-sm font-medium text-purple-700 bg-purple-50 hover:bg-purple-100">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Preview Gift Well
                        </a>
                        
                        <a href="{{ route('couples.gift-well.edit', $giftWell) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Details
                        </a>

                        @if($giftWell->wedding_date->isPast() && $giftWell->total_amount > 0 && $giftWell->status === 'active')
                        <div class="border-t pt-4 mt-6">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                <h4 class="font-semibold text-green-900 mb-2">Ready to Withdraw</h4>
                                <p class="text-sm text-green-700 mb-3">
                                    Available: <span class="font-bold">R{{ number_format($giftWell->withdrawable_amount) }}</span>
                                    <br>
                                    <small class="text-green-600">(R{{ number_format($giftWell->total_amount * 0.0395) }} withdrawal fee)</small>
                                </p>
                            </div>
                            <button onclick="initiateWithdrawal()" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                                Withdraw Funds
                            </button>
                        </div>
                        @elseif($giftWell->wedding_date->isFuture())
                        <div class="border-t pt-4 mt-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="font-semibold text-blue-900 mb-2">Withdrawal Available After Wedding</h4>
                                <p class="text-sm text-blue-700">
                                    You can withdraw funds after {{ $giftWell->wedding_date->format('M j, Y') }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Withdrawal Confirmation Modal -->
<div id="withdrawal-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Confirm Withdrawal</h3>
            <p class="text-gray-600">You're about to withdraw your gift well funds</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-6 space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Contributions:</span>
                <span class="font-semibold">R{{ number_format($giftWell->total_amount) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Withdrawal Fee (3.95%):</span>
                <span class="text-red-600">-R{{ number_format($giftWell->total_amount * 0.0395) }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold border-t pt-2">
                <span>You'll Receive:</span>
                <span class="text-green-600">R{{ number_format($giftWell->withdrawable_amount) }}</span>
            </div>
        </div>

        <div class="flex space-x-4">
            <button onclick="closeWithdrawalModal()" 
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-lg transition duration-200">
                Cancel
            </button>
            <button onclick="confirmWithdrawal()" 
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                Confirm Withdrawal
            </button>
        </div>
    </div>
</div>

<script>
    function copyGiftWellLink() {
        const link = '{{ route("guests.gift-well.show", $giftWell) }}';
        navigator.clipboard.writeText(link).then(() => {
            // Show toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            toast.textContent = 'Gift Well link copied to clipboard!';
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        });
    }

    function initiateWithdrawal() {
        document.getElementById('withdrawal-modal').classList.remove('hidden');
    }

    function closeWithdrawalModal() {
        document.getElementById('withdrawal-modal').classList.add('hidden');
    }

    async function confirmWithdrawal() {
        try {
            const response = await fetch('{{ route("couples.gift-well.withdraw", $giftWell) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });

            const result = await response.json();

            if (result.success) {
                window.location.reload();
            } else {
                alert('Withdrawal failed: ' + result.message);
            }
        } catch (error) {
            alert('Withdrawal failed. Please try again.');
        }
        
        closeWithdrawal Modal();
    }
</script>
@endsection