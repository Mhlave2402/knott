@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-4">Compare Quotes</h1>
        <p class="text-gray-600 mb-8">Here's a side-by-side comparison of the quotes you've received.</p>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Feature</th>
                        @foreach($responses as $response)
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $response->vendor->business_name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="py-4 px-6 font-medium">Quote Amount</td>
                        @foreach($responses as $response)
                            <td class="py-4 px-6">{{ number_format($response->quote_amount, 2) }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="py-4 px-6 font-medium">Rating</td>
                        @foreach($responses as $response)
                            <td class="py-4 px-6">{{ $response->vendor->average_rating ?? 'N/A' }} ({{ $response->vendor->reviews_count ?? 0 }} reviews)</td>
                        @endforeach
                    </tr>
                    <!-- Add more comparison rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
@endsection
