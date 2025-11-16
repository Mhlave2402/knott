@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Quote Requests
        </h2>
        <a href="{{ route('couple.quotes.create') }}" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded">
            Request a Quote
        </a>
    </div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="text-2xl">
                    Your Quote Requests
                </div>
            </div>

            <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1">
                @if($quoteRequests->isEmpty())
                    <div class="p-6 text-center">
                        <p class="text-gray-500">You haven't made any quote requests yet.</p>
                    </div>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Details
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Responses
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">View</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($quoteRequests as $request)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            Request for {{ $request->service->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Budget: R{{ number_format($request->budget, 2) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @switch($request->status)
                                                @case('pending') bg-yellow-100 text-yellow-800 @break
                                                @case('matched') bg-green-100 text-green-800 @break
                                                @case('failed') bg-red-100 text-red-800 @break
                                                @default bg-gray-100 text-gray-800
                                            @endswitch
                                        ">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $request->quote_responses_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('couple.quotes.show', $request) }}" class="text-rose-600 hover:text-rose-900">View</a>
                                        @if($request->quote_responses_count >= 2)
                                            <a href="{{ route('couple.quotes.compare', $request) }}" class="text-indigo-600 hover:text-indigo-900 ml-4">Compare</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
