@extends('layouts.couple')

@push('head')
<style>
    .comparison-card {
        background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        border: 2px solid transparent;
        background-clip: padding-box;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    .comparison-card.featured {
        border-color: #8B5CF6;
        box-shadow: 0 10px 40px rgba(139, 92, 246, 0.2);
    }
    .feature-check {
        background: linear-gradient(135deg, #10B981, #059669);
    }
    .feature-cross {
        background: linear-gradient(135deg, #EF4444, #DC2626);
    }
</style>
@endpush

@section('title', 'Compare Quotes')
@section('header', 'Compare Wedding Vendor Quotes')
@section('description', 'Easily view, compare, and manage all your vendor quotes in one dashboard.')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="comparisonDashboard()">
    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" x-model="filters.category">
                    <option value="">All Categories</option>
                    <option value="venue">Venue</option>
                    <option value="catering">Catering</option>
                    <option value="photography">Photography</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                <select class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" x-model="filters.sortBy">
                    <option value="price">Price (Lowest)</option>
                    <option value="rating">Rating (Highest)</option>
                    <option value="date">Date (Newest)</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button @click="applyFilters" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    Apply Filters
                </button>
            </div>
        </div>
    </div>
    
    <!-- Quotes Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="quote in filteredQuotes" :key="quote.id">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="quote.vendor"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="quote.category"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="`$${quote.price}`"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="text-yellow-400" x-text="'★'.repeat(quote.rating)"></span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500" x-text="quote.details"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-purple-600 hover:text-purple-900" @click="viewQuote(quote)">View</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function comparisonDashboard() {
        return {
            filters: { category: '', sortBy: 'price' },
            quotes: [
                { id: 1, vendor: 'Elegant Events', category: 'venue', price: 5000, rating: 5, details: 'Includes catering and decoration' },
                { id: 2, vendor: 'Gourmet Catering', category: 'catering', price: 3500, rating: 4, details: 'Buffet style, includes staff' },
                { id: 3, vendor: 'Memories Photography', category: 'photography', price: 2500, rating: 5, details: 'Full-day coverage, 2 photographers' },
            ],
            get filteredQuotes() {
                let result = this.quotes;
                if (this.filters.category) {
                    result = result.filter(q => q.category === this.filters.category);
                }
                if (this.filters.sortBy === 'price') result.sort((a,b) => a.price - b.price);
                if (this.filters.sortBy === 'rating') result.sort((a,b) => b.rating - a.rating);
                return result;
            },
            applyFilters() { /* triggers reactivity */ },
            viewQuote(quote) {
                alert(`Viewing quote from ${quote.vendor} - ${quote.details}`);
            }
        }
    }
</script>
@endpush
