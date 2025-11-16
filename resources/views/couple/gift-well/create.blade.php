@extends('layouts.dashboard')

@section('title', 'Create Gift Well')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Your Wedding Gift Well</h1>
            <p class="text-gray-600">Set up a digital registry for your guests to contribute to your special day</p>
        </div>

        <form action="{{ route('couples.gift-well.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Basic Information</h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Gift Well Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="e.g., Sarah & John's Wedding Fund" required>
                        @error('title')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="wedding_date" class="block text-sm font-medium text-gray-700 mb-2">Wedding Date</label>
                        <input type="date" id="wedding_date" name="wedding_date" value="{{ old('wedding_date') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        @error('wedding_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                              placeholder="Tell your guests about your special day and what their contributions will help with...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Target Amount (Optional) -->
            <div class="bg-white rounded-xl shadow-sm p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Target Amount (Optional)</h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="target_amount" class="block text-sm font-medium text-gray-700 mb-2">Target Amount (R)</label>
                        <input type="number" id="target_amount" name="target_amount" value="{{ old('target_amount') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="e.g., 50000" min="0" step="100">
                        @error('target_amount')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">Leave empty if you don't want to set a target</p>
                    </div>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div class="bg-white rounded-xl shadow-sm p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Privacy Settings</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_public" name="is_public" type="checkbox" value="1" 
                                   {{ old('is_public', true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_public" class="font-medium text-gray-700">Make Gift Well Public</label>
                            <p class="text-gray-500">Allow guests to find and contribute to your gift well via a shareable link</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thank You Message -->
            <div class="bg-white rounded-xl shadow-sm p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Thank You Message</h2>
                
                <div>
                    <label for="thank_you_message" class="block text-sm font-medium text-gray-700 mb-2">Custom Thank You Message</label>
                    <textarea id="thank_you_message" name="thank_you_message" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                              placeholder="Thank you for your generous contribution to our special day!">{{ old('thank_you_message', 'Thank you for your generous contribution to our special day!') }}</textarea>
                    @error('thank_you_message')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">This message will be shown to guests after they contribute</p>
                </div>
            </div>

            <!-- Fees Information -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-4">💰 Fee Structure</h3>
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Guest Fee</h4>
                        <p class="text-gray-600">Guests pay an additional <strong>10%</strong> on their contribution</p>
                        <p class="text-xs text-gray-500 mt-1">e.g., R100 contribution = R110 total paid by guest</p>
                    </div>
                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Withdrawal Fee</h4>
                        <p class="text-gray-600">You pay <strong>3.95%</strong> when withdrawing funds</p>
                        <p class="text-xs text-gray-500 mt-1">e.g., R1000 received = R39.50 fee, R960.50 to you</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between">
                <a href="{{ route('couples.gift-well.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition duration-200">
                    Create Gift Well
                </button>
            </div>
        </form>
    </div>
</div>
@endsection