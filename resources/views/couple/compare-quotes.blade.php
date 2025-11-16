@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Compare Quotes for {{ $quoteRequest->service->name ?? 'N/A' }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="text-2xl">
                    Side-by-Side Comparison
                </div>
                <p class="mt-2 text-gray-600">
                    Here's a comparison of the quotes you've received.
                </p>
            </div>

            <div class="p-6 sm:px-20 bg-white">
                <div class="grid grid-cols-1 md:grid-cols-{{ count($responses) + 1 }} gap-4">
                    <!-- Features Column -->
                    <div class="font-bold">
                        <div class="h-16"></div>
                        <div>Price</div>
                        <div>Rating</div>
                        <div>Features</div>
                    </div>

                    <!-- Vendor Columns -->
                    @foreach($responses as $response)
                        <div class="text-center border rounded-lg p-4">
                            <h3 class="text-lg font-bold">{{ $response->vendor->business_name }}</h3>
                            <div class="mt-4">
                                <div class="h-16">
                                    <img src="{{ $response->vendor->user->profile_photo_url }}" alt="{{ $response->vendor->business_name }}" class="w-16 h-16 rounded-full mx-auto">
                                </div>
                                <div class="mt-4">R{{ number_format($response->quote_amount, 2) }}</div>
                                <div class="mt-2">{{ $response->vendor->average_rating ?? 'N/A' }} ★</div>
                                <ul class="mt-4 text-left">
                                    @foreach($comparisonData['features_comparison'] as $vendorFeatures)
                                        @if($vendorFeatures['vendor'] === $response->vendor->business_name)
                                            @foreach($vendorFeatures['features'] as $feature)
                                                <li class="{{ $feature['included'] ? 'text-green-500' : 'text-red-500' }}">
                                                    {{ $feature['name'] }}
                                                </li>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </ul>
                                <div class="mt-6">
                                    <a href="#" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded">
                                        Accept Quote
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
