@extends('layouts.app')

@section('title', $giftWell->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-pink-50">
    <!-- Hero Section -->
    <div class="relative bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-4">{{ $giftWell->title }}</h1>
                <p class="text-xl text-gray-600 mb-8">{{ $giftWell->description }}</p>
                
                <!-- Wedding Date -->
                <div class="inline-flex items-center bg-purple-100 text-purple-800 px-6 py-3 rounded-full text-lg font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $giftWell->wedding_date->format('F j, Y') }}
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Progress Section -->
                @if($giftWell->target_amount)
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Our Progress</h2>
                    
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">R{{ number_format($giftWell->total_amount) }} raised</span>
                            <span class="text-sm font-medium text-gray-700">R{{ number_format($giftWell->target_amount) }} goal</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-4 rounded-full transition-all duration-500" 
                                 style="width: {{ $giftWell->progress_percentage }}%"></div>
                        </div>
                        <p class="text-center text-lg font-semibold text-purple-600 mt-2">{{ $giftWell->progress_percentage }}% Complete</p>
                    </div>
                </div>
                @endif

                <!-- Recent Contributors -->
                @if($recentContributions->isNotEmpty())
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Contributors</h2>
                    
                    <div class="space-y-4">
                        @foreach($recentContributions as $contribution)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($contribution->display_name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $contribution->display_name }}</h3>
                                <p class="text-gray-600 text-sm">Contributed R{{ number_format($contribution->amount) }}</p>
                                @if($contribution->message)
                                <p class="text-gray-700 text-sm mt-1 italic">"{{ $contribution->message }}"</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">{{ $contribution->paid_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Contribution Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-8 sticky top-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Make a Contribution</h2>
                    
                    <form id="contribution-form" class="space-y-6">
                        @csrf
                        <input type="hidden" name="gift_well_id" value="{{ $giftWell->id }}">
                        
                        <!-- Contribution Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Contribution Amount (R)</label>
                            <input type="number" id="amount" name="amount" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-lg font-semibold"
                                   placeholder="100" min="10" step="10" required>
                            <div id="fee-display" class="text-sm text-gray-600 mt-1 hidden">
                                + R<span id="fee-amount">0</span> processing fee = R<span id="total-amount">0</span> total
                            </div>
                        </div>

                        <!-- Guest Information -->
                        <div>
                            <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-2">Your Name</label>
                            <input type="text" id="guest_name" name="guest_name" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="Enter your full name" required>
                        </div>

                        <div>
                            <label for="guest_email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="guest_email" name="guest_email" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="your@email.com" required>
                        </div>

                        <div>
                            <label for="guest_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number (Optional)</label>
                            <input type="tel" id="guest_phone" name="guest_phone" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="+27 12 345 6789">
                        </div>

                        <!-- Personal Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Personal Message (Optional)</label>
                            <textarea id="message" name="message" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Write a heartfelt message to the couple..."></textarea>
                        </div>

                        <!-- Anonymous Option -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_anonymous" name="is_anonymous" type="checkbox" 
                                       class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_anonymous" class="font-medium text-gray-700">Contribute Anonymously</label>
                                <p class="text-gray-500">Your name won't be shown publicly</p>
                            </div>
                        </div>

                        <!-- Payment Section -->
                        <div id="card-element" class="p-4 border border-gray-300 rounded-lg">
                            <!-- Stripe Elements will create form elements here -->
                        </div>
                        <div id="card-errors" class="text-red-600 text-sm" role="alert"></div>

                        <!-- Submit Button -->
                        <button type="submit" id="submit-button" 
                                class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 text-lg">
                            <span id="button-text">Contribute Now</span>
                            <svg id="loading-spinner" class="hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="success-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Thank You!</h3>
        <p class="text-gray-600 mb-6">{{ $giftWell->thank_you_message }}</p>
        <button onclick