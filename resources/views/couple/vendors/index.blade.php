<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vendor Directory
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Find Vendors</h3>
                    </div>
                    
                    <!-- Vendor List -->
                    <div class="space-y-4">
                        @foreach($vendors as $vendor)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="text-lg font-semibold">{{ $vendor->name }}</h4>
                                <p class="text-gray-600">{{ $vendor->description }}</p>
                                <p class="text-sm text-gray-500">{{ $vendor->category }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
