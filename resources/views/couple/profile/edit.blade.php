@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Your Profile
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('couple.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Partner Name -->
                            <div>
                                <label for="partner_name" class="block text-sm font-medium text-gray-700">Partner's Name</label>
                                <input type="text" name="partner_name" id="partner_name" value="{{ old('partner_name', $profile->partner_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <!-- Partner Email -->
                            <div>
                                <label for="partner_email" class="block text-sm font-medium text-gray-700">Partner's Email</label>
                                <input type="email" name="partner_email" id="partner_email" value="{{ old('partner_email', $profile->partner_email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <!-- Wedding Date -->
                            <div>
                                <label for="wedding_date" class="block text-sm font-medium text-gray-700">Wedding Date</label>
                                <input type="date" name="wedding_date" id="wedding_date" value="{{ old('wedding_date', $profile->wedding_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Venue Location -->
                            <div>
                                <label for="venue_location" class="block text-sm font-medium text-gray-700">Venue Location</label>
                                <input type="text" name="venue_location" id="venue_location" value="{{ old('venue_location', $profile->venue_location) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Guest Count -->
                            <div>
                                <label for="guest_count" class="block text-sm font-medium text-gray-700">Estimated Guest Count</label>
                                <input type="number" name="guest_count" id="guest_count" value="{{ old('guest_count', $profile->guest_count) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Total Budget -->
                            <div>
                                <label for="total_budget" class="block text-sm font-medium text-gray-700">Total Budget</label>
                                <input type="number" name="total_budget" id="total_budget" value="{{ old('total_budget', $profile->total_budget) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Wedding Style -->
                            <div class="md:col-span-2">
                                <label for="wedding_style" class="block text-sm font-medium text-gray-700">Wedding Style</label>
                                <input type="text" name="wedding_style" id="wedding_style" value="{{ old('wedding_style', $profile->wedding_style) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., Modern, Traditional, Rustic">
                            </div>

                            <!-- Preferences -->
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
