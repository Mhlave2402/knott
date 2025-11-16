@extends('layouts.app')

@section('title', 'Create Your Couple Profile')

@section('header', 'Create Your Profile')
@section('description', "Let's get some details to start planning your wedding.")

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('couple.profile.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Partner Name -->
            <div>
                <label for="partner_name" class="block text-sm font-medium text-gray-700">Partner's Name</label>
                <input type="text" name="partner_name" id="partner_name" value="{{ old('partner_name') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                @error('partner_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Partner Email -->
            <div>
                <label for="partner_email" class="block text-sm font-medium text-gray-700">Partner's Email</label>
                <input type="email" name="partner_email" id="partner_email" value="{{ old('partner_email') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                @error('partner_email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Wedding Date -->
            <div>
                <label for="wedding_date" class="block text-sm font-medium text-gray-700">Wedding Date</label>
                <input type="date" name="wedding_date" id="wedding_date" value="{{ old('wedding_date') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                @error('wedding_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Venue Location -->
            <div>
                <label for="venue_location" class="block text-sm font-medium text-gray-700">Venue Location</label>
                <input type="text" name="venue_location" id="venue_location" value="{{ old('venue_location') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                @error('venue_location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Guest Count -->
            <div>
                <label for="guest_count" class="block text-sm font-medium text-gray-700">Estimated Guest Count</label>
                <input type="number" name="guest_count" id="guest_count" value="{{ old('guest_count') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                @error('guest_count')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total Budget -->
            <div>
                <label for="total_budget" class="block text-sm font-medium text-gray-700">Estimated Total Budget</label>
                <input type="number" name="total_budget" id="total_budget" value="{{ old('total_budget') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                @error('total_budget')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Wedding Style -->
        <div>
            <label for="wedding_style" class="block text-sm font-medium text-gray-700">Wedding Style</label>
            <input type="text" name="wedding_style" id="wedding_style" value="{{ old('wedding_style') }}"
                   placeholder="e.g., Modern, Rustic, Classic"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
            @error('wedding_style')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Save Profile
            </button>
        </div>
    </form>
</div>
@endsection
