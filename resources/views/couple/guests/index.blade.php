@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Guest List
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if(session('success'))
                        <div class="mb-4 text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Guest Statistics</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2 text-center">
                            <div class="p-4 bg-gray-100 rounded-lg">
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_guests'] }}</div>
                                <div class="text-sm text-gray-600">Total Guests</div>
                            </div>
                            <div class="p-4 bg-green-100 rounded-lg">
                                <div class="text-2xl font-bold text-green-800">{{ $stats['confirmed'] }}</div>
                                <div class="text-sm text-green-600">Confirmed</div>
                            </div>
                            <div class="p-4 bg-yellow-100 rounded-lg">
                                <div class="text-2xl font-bold text-yellow-800">{{ $stats['pending'] }}</div>
                                <div class="text-sm text-yellow-600">Pending</div>
                            </div>
                            <div class="p-4 bg-red-100 rounded-lg">
                                <div class="text-2xl font-bold text-red-800">{{ $stats['declined'] }}</div>
                                <div class="text-sm text-red-600">Declined</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">All Guests</h3>
                        <div>
                            <a href="{{ route('couple.guests.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-sm">
                                Add Guest
                            </a>
                            <button onclick="document.getElementById('importModal').style.display='block'" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg text-sm ml-2">
                                Import CSV
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        RSVP Status
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Plus One
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($guests as $guest)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $guest->name }}</p>
                                            <p class="text-gray-600 whitespace-no-wrap text-xs">{{ $guest->email }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap capitalize">{{ $guest->category }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                <span aria-hidden class="absolute inset-0 {{ $guest->rsvp_status == 'attending' ? 'bg-green-200' : ($guest->rsvp_status == 'declined' ? 'bg-red-200' : 'bg-yellow-200') }} opacity-50 rounded-full"></span>
                                                <span class="relative capitalize">{{ $guest->rsvp_status }}</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $guest->plus_one }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                            <a href="{{ route('couple.guests.edit', $guest) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('couple.guests.destroy', $guest) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Are you sure you want to remove this guest?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                            No guests have been added yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $guests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="fixed z-10 inset-0 overflow-y-auto" style="display:none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('couple.guests.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Import Guests from CSV
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Select a CSV file to import. The file should have columns: `name`, `email`, `phone`, `category`, `plus_one`.
                            </p>
                            <input type="file" name="csv_file" class="mt-2" required>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                            Import
                        </button>
                        <button type="button" onclick="document.getElementById('importModal').style.display='none'" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
