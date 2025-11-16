<!-- FILE: resources/views/public/home.blade.php -->
@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-purple-600 via-pink-500 to-red-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                Plan Your Perfect Wedding with 
                <span class="bg-gradient-to-r from-yellow-200 to-orange-200 bg-clip-text text-transparent">AI Magic</span>
            </h1>
            <p class="text-xl text-purple-100 mb-8 max-w-3xl mx-auto">
                Get instant vendor matches, smart budget tracking, and seamless gift wells. 
                Everything you need for your dream wedding, powered by intelligent technology.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('register') }}" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-all duration-200 shadow-lg">
                    Start Planning Free
                </a>
                <a href="#features" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition-all duration-200">
                    See How It Works
                </a>
            </div>
            
            <div class="mt-12 text-purple-200 text-sm">
                ✨ Join 10,000+ couples who've found their perfect vendors
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Everything You Need in One Place</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">From AI-powered vendor matching to seamless gift wells, we've got every aspect of your wedding covered.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- AI Matching -->
            <div class="text-center p-6 rounded-lg border border-gray-100 hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">AI Vendor Matching</h3>
                <p class="text-gray-600">Get instantly matched with vendors that fit your budget, style, and location. No more endless searching.</p>
            </div>
            
            <!-- Budget Tracking -->
            <div class="text-center p-6 rounded-lg border border-gray-100 hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Smart Budget Tracker</h3>
                <p class="text-gray-600">Stay on track with intelligent budget monitoring and spending alerts. Never go over budget again.</p>
            </div>
            
            <!-- Gift Wells -->
            <div class="text-center p-6 rounded-lg border border-gray-100 hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-gradient-to-r from-pink-500 to-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.5 1.5 0 013 15.546V12a9 9 0 1118 0v3.546z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Digital Gift Wells</h3>
                <p class="text-gray-600">Modern gift registries that let guests contribute to your dreams. Secure, transparent, and meaningful.</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-r from-purple-600 to-pink-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Start Planning?</h2>
        <p class="text-xl text-purple-100 mb-8 max-w-2xl mx-auto">
            Join thousands of couples who've simplified their wedding planning with Knott. 
            It's free to get started!
        </p>
        <a href="{{ route('register') }}" class="bg-white text-purple-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-50 transition-all duration-200 shadow-lg text-lg">
            Create Your Free Account
        </a>
    </div>
</div>
@endsection