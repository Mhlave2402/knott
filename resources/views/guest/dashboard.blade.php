<!-- FILE: resources/views/guest/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Guest Dashboard')
@section('header', 'Gift Well Dashboard')
@section('description', 'Contribute to wedding gift wells and celebrate love')

@section('content')
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-pink-400 to-purple-500 rounded-lg shadow-sm mb-8">
        <div class="px-6 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">
                        Welcome, {{ auth()->user()->name ?? 'Guest' }}! 🎁
                    </h2>
                    <p class="text-pink-100 mt-2">
                        Help make wedding dreams come true with meaningful contributions
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                        <span class="text-3xl">💝</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mb-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Contributions</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                R{{ number_format((float)($stats['total_contributions'] ?? 0), 2) }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.5 1.5 0 013 15.546V12a9 9 0 1118 0v3.546z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Gift Wells</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ $stats['active_gift_wells'] ?? count($giftWells ?? []) }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Gift Wells (full width) -->
    <div class="bg-white rounded-lg shadow-sm mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Available Gift Wells</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Contribute to your friends' and family's special day
                    </p>
                </div>

                <form method="GET" action="{{ url()->current() }}" class="hidden md:block">
                    <div class="relative">
                        <input
                            name="q"
                            value="{{ request('q') }}"
                            type="text"
                            placeholder="Search gift wells..."
                            class="pl-10 pr-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                        >
                        <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/>
                        </svg>
                    </div>
                </form>
            </div>
        </div>

        <div class="p-6">
            @forelse(($giftWells ?? []) as $giftWell)
                @php
                    $title       = data_get($giftWell, 'title') ?? data_get($giftWell, 'name') ?? 'Gift Well';
                    $description = data_get($giftWell, 'description');
                    $goal        = data_get($giftWell, 'goal_amount') ?? data_get($giftWell, 'target_amount');
                    $raised      = data_get($giftWell, 'raised_amount') ?? data_get($giftWell, 'contributions_sum_amount') ?? 0;
                    $progress    = $goal ? min(100, (int) round(($raised / max(1, $goal)) * 100)) : null;
                    $image       = data_get($giftWell, 'cover_url') ?? data_get($giftWell, 'image_url');
                    $id          = data_get($giftWell, 'slug') ?? data_get($giftWell, 'id');
                    $showUrl     = $id ? url('/gift-wells/'.$id) : '#';
                    $contribUrl  = $id ? url('/gift-wells/'.$id.'/contribute') : '#';
                    $weddingDate = data_get($giftWell, 'wedding_date') ?? data_get($giftWell, 'end_date');
                @endphp

                <div class="flex gap-4 p-4 border border-gray-100 rounded-xl mb-4">
                    <div class="w-24 h-24 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                        @if($image)
                            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-3xl">🎀</span>
                        @endif
                    </div>

                    <div class="flex-1">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h4 class="text-base sm:text-lg font-semibold text-gray-900">{{ $title }}</h4>
                            @if($weddingDate)
                                <span class="text-xs sm:text-sm text-gray-500">
                                    Event: {{ \Illuminate\Support\Carbon::parse($weddingDate)->toFormattedDateString() }}
                                </span>
                            @endif
                        </div>

                        @if($description)
                            <p class="text-sm text-gray-600 mt-1">
                                {{ \Illuminate\Support\Str::limit(strip_tags($description), 140) }}
                            </p>
                        @endif

                        @if(!is_null($progress))
                            <div class="mt-3">
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-pink-500" style="width: {{ $progress }}%"></div>
                                </div>
                                <div class="mt-1 text-xs text-gray-600">
                                    Raised: R{{ number_format((float)$raised, 2) }}
                                    <span class="mx-1">•</span>
                                    Goal: R{{ number_format((float)$goal, 2) }}
                                    <span class="mx-1">•</span>
                                    {{ $progress }}%
                                </div>
                            </div>
                        @endif

                        <div class="mt-4 flex items-center gap-3">
                            <a href="{{ $contribUrl }}"
                               class="inline-flex items-center px-4 py-2 rounded-lg bg-pink-600 text-white hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                                Contribute
                            </a>
                            <a href="{{ $showUrl }}"
                               class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-pink-50 flex items-center justify-center">
                        <span class="text-2xl">💗</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">No gift wells available yet</h4>
                    <p class="text-sm text-gray-600 mt-1">
                        When your friends create a gift well, you'll see it here.
                    </p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Activity (full width below) -->
    @isset($activities)
        <div class="bg-white rounded-lg shadow-sm mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
            </div>
            <div class="p-6">
                @forelse($activities as $activity)
                    @php
                        $aTitle   = data_get($activity, 'title') ?? 'Activity';
                        $aSub     = data_get($activity, 'subtitle');
                        $aTime    = data_get($activity, 'time') ?? data_get($activity, 'created_at');
                    @endphp
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">{{ $aTitle }}</p>
                                @if($aSub)
                                    <p class="text-sm text-gray-500">{{ $aSub }}</p>
                                @endif
                            </div>
                        </div>
                        @if($aTime)
                            <div class="text-xs text-gray-500">
                                {{ \Illuminate\Support\Carbon::parse($aTime)->diffForHumans() }}
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-600">No recent activity.</p>
                @endforelse
            </div>
        </div>
    @endisset
@endsection
