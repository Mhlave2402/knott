@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Welcome back, {{ Auth::user()->name }}! 💕
            </h2>
            @if($profile->wedding_date)
            <p class="text-sm text-gray-600 mt-1">
                {{ abs($stats['days_until_wedding']) }} days 
                {{ $stats['days_until_wedding'] >= 0 ? 'until' : 'since' }} your wedding
            </p>
            @endif
        </div>
        <div class="text-right">
            <a href="{{ route('couple.profile.edit') }}" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded">
                Edit Profile
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Wedding Countdown Card -->
        @if($profile->wedding_date)
        <div class="bg-gradient-to-r from-rose-400 to-pink-500 overflow-hidden shadow-xl sm:rounded-lg mb-8">
            <div class="p-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">{{ $profile->partner_name ? $profile->user->name . ' & ' . $profile->partner_name : 'Your Wedding' }}</h3>
                        <p class="text-rose-100 mt-1">{{ $profile->wedding_date->format('F j, Y') }}</p>
                        @if($profile->venue_location)
                        <p class="text-rose-100 text-sm">📍 {{ $profile->venue_location }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="text-4xl font-bold">{{ abs($stats['days_until_wedding']) }}</div>
                        <div class="text-sm text-rose-100">days {{ $stats['days_until_wedding'] >= 0 ? 'to go' : 'ago' }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Budget Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                💰
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Budget Used</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ number_format($stats['budget_utilization'], 1) }}%
                                </dd>
                                <dd class="text-xs text-gray-500">
                                    R{{ number_format($stats['total_spent'], 0) }} of R{{ number_format($stats['total_budget'] ?? 0, 0) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="bg-gray-200 rounded-full h-2">
                            <div class="bg-{{ $stats['budget_utilization'] > 90 ? 'red' : 'green' }}-500 h-2 rounded-full"
                                 style="width: {{ min(100, $stats['budget_utilization']) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guests Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                👥
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">RSVP Status</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['confirmed_guests'] }} confirmed</dd>
                                <dd class="text-xs text-gray-500">{{ $stats['pending_rsvp'] }} pending responses</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('couple.guests.index') }}" class="text-sm text-blue-600 hover:text-blue-900">
                            Manage guest list →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tasks Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                ✓
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Tasks Progress</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $stats['completed_todos'] }}/{{ $stats['total_todos'] }} done
                                </dd>
                                <dd class="text-xs text-gray-500">
                                    {{ $stats['total_todos'] > 0 ? number_format(($stats['completed_todos'] / $stats['total_todos']) * 100, 1) : 0 }}% complete
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('couple.todos.index') }}" class="text-sm text-purple-600 hover:text-purple-900">
                            View all tasks →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Vendors Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-rose-500 rounded-full flex items-center justify-center">
                                💼
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Find Vendors</dt>
                                <dd class="text-lg font-medium text-gray-900">AI-Powered Matching</dd>
                                <dd class="text-xs text-gray-500">Find your perfect vendors</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('couple.vendors.index') }}" class="text-sm text-rose-600 hover:text-rose-900">
                            Explore Vendors →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Tasks -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Upcoming Tasks</h3>
                    
                    @if($profile->todos()->pending()->limit(5)->get()->count() > 0)
                        <ul class="space-y-3">
                            @foreach($profile->todos()->pending()->orderBy('due_date')->limit(5)->get() as $todo)
                            <li class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <form method="POST" action="{{ route('couple.todos.toggle', $todo) }}" class="mr-3">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="h-4 w-4 text-rose-600 border border-gray-300 rounded focus:ring-rose-500">
                                            <span class="sr-only">Mark complete</span>
                                        </button>
                                    </form>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $todo->title }}</p>
                                        @if($todo->due_date)
                                        <p class="text-xs text-gray-500">Due {{ $todo->due_date->format('M j') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $todo->priority_color }}-100 text-{{ $todo->priority_color }}-800">
                                    {{ ucfirst($todo->priority) }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                        
                        <div class="mt-4">
                            <a href="{{ route('couple.todos.index') }}" class="text-sm text-rose-600 hover:text-rose-900 font-medium">
                                View all tasks →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-500 mb-4">No pending tasks</p>
                            <form method="POST" action="{{ route('couple.todos.suggestions') }}">
                                @csrf
                                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded">
                                    Get Planning Suggestions
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Budget Overview -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Budget Overview</h3>
                    
                    @if($profile->budgetCategories->count() > 0)
                        <div class="space-y-4">
                            @foreach($profile->budgetCategories->sortByDesc('utilization_percentage')->take(5) as $category)
                            <div>
                                <div class="flex justify-between text-sm">
                                    <span class="font-medium text-gray-900">{{ $category->name }}</span>
                                    <span class="text-gray-500">{{ number_format($category->utilization_percentage, 1) }}%</span>
                                </div>
                                <div class="mt-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-{{ $category->is_over_budget ? 'red' : 'rose' }}-500 h-2 rounded-full"
                                         style="width: {{ min(100, $category->utilization_percentage) }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>R{{ number_format($category->spent_amount, 0) }}</span>
                                    <span>R{{ number_format($category->allocated_amount, 0) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('couple.budget.index') }}" class="text-sm text-rose-600 hover:text-rose-900 font-medium">
                                Manage budget →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-500 mb-4">Set up your budget to start tracking expenses</p>
                            <a href="{{ route('couple.budget.index') }}" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded">
                                Setup Budget
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
