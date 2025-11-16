@extends('layouts.vendor')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Your Vendor Profile
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900">Business Information</h3>
                    <p class="mt-1 text-sm text-gray-600">Tell couples about your wedding services.</p>
                </div>

                <form method="POST" action="{{ route('vendor.profile.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name *</label>
                            <input type="text" id="business_name" name="business_name" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                   value="{{ old('business_name') }}">
                            @error('business_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location *</label>
                            <input type="text" id="location" name="location" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                   placeholder="City, Province"
                                   value="{{ old('location') }}">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Business Description *</label>
                        <textarea id="description" name="description" rows="4" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                  placeholder="Describe your services, experience, and what makes you special...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                            <input type="url" id="website" name="website"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                   placeholder="https://yourwebsite.com"
                                   value="{{ old('website') }}">
                            @error('website')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="starting_price" class="block text-sm font-medium text-gray-700">Starting Price (R)</label>
                        <input type="number" id="starting_price" name="starting_price" step="0.01" min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                               placeholder="Your lowest service price"
                               value="{{ old('starting_price') }}">
                        @error('starting_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="instagram" class="block text-sm font-medium text-gray-700">Instagram URL</label>
                            <input type="url" id="instagram" name="social_media[instagram]"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                   placeholder="https://instagram.com/yourbusiness"
                                   value="{{ old('social_media.instagram') }}">
                        </div>

                        <div>
                            <label for="facebook" class="block text-sm font-medium text-gray-700">Facebook URL</label>
                            <input type="url" id="facebook" name="social_media[facebook]"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500"
                                   placeholder="https://facebook.com/yourbusiness"
                                   value="{{ old('social_media.facebook') }}">
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('vendor.dashboard') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-200">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                            Create Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection