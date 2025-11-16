@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-purple-50 via-white to-pink-50 min-h-screen" x-data="comparisonDashboard({
    quoteRequest: {{ Js::from($quoteRequest) }},
    vendors: {{ Js::from($vendors) }}
})">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Compare Vendor Quotes</h1>
                <p class="text-gray-600">Your Dream Wedding • <span class="font-semibold text-purple-600">{{ $quoteRequest->guest_count }}</span> Guests • <span class="font-semibold text-green-600">R{{ number_format($quoteRequest->budget, 0, ',', ' ') }}</span> Budget</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Quote Request</div>
                <div class="font-semibold text-gray-800">#QR-{{ $quoteRequest->id }}</div>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <div>
                    <div class="text-2xl font-bold text-gray-800">{{ count($vendors) }}</div>
                    <div class="text-sm text-gray-600">Quotes Received</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">R<span x-text="formatNumber(averagePrice)"></span></div>
                    <div class="text-sm text-gray-600">Average Quote</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800" x-text="averageRating.toFixed(1)"></div>
                    <div class="text-sm text-gray-600">Average Rating</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800" x-text="averageResponseTime"></div>
                    <div class="text-sm text-gray-600">Avg Response Time</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 mb-8">
        <div class="flex flex-wrap items-center gap-4">
            <div>
                <label class="text-sm font-medium text-gray-700 mr-2">Sort by:</label>
                <select x-model="sortBy" @change="sortVendors()" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                    <option value="rating_desc">Highest Rated</option>
                    <option value="compatibility_desc">Best Match</option>
                    <option value="response_time">Fastest Response</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 mr-2">Budget Range:</label>
                <select x-model="budgetFilter" @change="filterVendors()" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="all">All Prices</option>
                    <option value="within_budget">Within Budget</option>
                    <option value="slightly_over">Up to 20% Over</option>
                </select>
            </div>
            <div class="flex items-center">
                <input type="checkbox" x-model="showFeaturesOnly" @change="filterVendors()" id="features-only" class="mr-2">
                <label for="features-only" class="text-sm text-gray-700">Show full-service only</label>
            </div>
        </div>
    </div>

    <!-- Comparison Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
        <template x-for="(vendor, index) in filteredVendors" :key="vendor.id">
            <div class="comparison-card rounded-2xl p-6 relative" :class="vendor.featured ? 'featured' : ''">
                <!-- Featured Badge -->
                <div x-show="vendor.featured" class="absolute -top-3 left-6 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-1 rounded-full text-sm font-medium">
                    ⭐ Best Match
                </div>

                <!-- Vendor Header -->
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center">
                        <img :src="vendor.avatar" :alt="vendor.business_name" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800" x-text="vendor.business_name"></h3>
                            <div class="flex items-center mt-1">
                                <div class="flex items-center mr-2">
                                    <template x-for="i in 5" :key="i">
                                        <svg class="w-4 h-4" :class="i <= vendor.rating ? 'text-yellow-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    </template>
                                </div>
                                <span class="text-sm text-gray-600" x-text="vendor.rating + ' (' + vendor.reviews_count + ' reviews)'"></span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-green-600">R<span x-text="formatNumber(vendor.quote_amount)"></span></div>
                        <div class="text-sm text-gray-500">Total Package</div>
                    </div>
                </div>

                <!-- AI Compatibility Score -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">AI Compatibility</span>
                        <span class="text-lg font-bold text-purple-600" x-text="vendor.compatibility_score + '%'"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all duration-1000" 
                             :style="'width: ' + vendor.compatibility_score + '%'"></div>
                    </div>
                    <div class="mt-2">
                        <div class="text-xs text-gray-600">Perfect match reasons:</div>
                        <div class="flex flex-wrap gap-1 mt-1">
                            <template x-for="reason in vendor.match_reasons.slice(0, 3)" :key="reason">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-700" x-text="reason"></span>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Package Details -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3">Package: <span x-text="vendor.package_name"></span></h4>
                    <p class="text-gray-600 text-sm mb-4" x-text="vendor.package_description"></p>
                    
                    <!-- Key Features -->
                    <div class="grid grid-cols-2 gap-2">
                        <template x-for="feature in vendor.key_features.slice(0, 6)" :key="feature">
                            <div class="flex items-center text-sm">
                                <div class="w-4 h-4 feature-check rounded-full flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-gray-700" x-text="feature"></span>
                            </div>
                        </template>
                    </div>
                    
                    <button @click="showFullDetails(vendor)" class="text-purple-600 text-sm font-medium mt-2 hover:text-purple-700">
                        View all features →
                    </button>
                </div>

                <!-- Response Time & Contact -->
                <div class="border-t border-gray-200 pt-4 mb-6">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <div class="text-gray-500">Response Time</div>
                            <div class="font-semibold text-gray-800" x-text="vendor.response_time"></div>
                        </div>
                        <div>
                            <div class="text-gray-500">Next Available</div>
                            <div class="font-semibold text-gray-800" x-text="vendor.next_available"></div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button 
                        @click="acceptQuote(vendor)"
                        class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 rounded-lg font-semibold hover:from-green-700 hover:to-green-800 transition-all transform hover:scale-105"
                    >
                        Accept Quote
                    </button>
                    <div class="grid grid-cols-2 gap-2">
                        <button 
                            @click="requestMoreInfo(vendor)"
                            class="px-4 py-2 border border-purple-500 text-purple-600 rounded-lg hover:bg-purple-50 transition-colors text-sm"
                        >
                            More Info
                        </button>
                        <button 
                            @click="scheduleCall(vendor)"
                            class="px-4 py-2 border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors text-sm"
                        >
                            Schedule Call
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Detailed Feature Comparison Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800">Detailed Feature Comparison</h3>
            <p class="text-gray-600 mt-2">Compare features side-by-side to make the best decision</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-4 font-semibold text-gray-700">Features</th>
                        <template x-for="vendor in filteredVendors.slice(0, 4)" :key="vendor.id">
                            <th class="text-center p-4 font-semibold text-gray-700 min-w-36">
                                <div x-text="vendor.business_name.split(' ')[0]"></div>
                                <div class="text-sm font-normal text-green-600">R<span x-text="formatNumber(vendor.quote_amount)"></span></div>
                            </th>
                        </template>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <template x-for="feature in commonFeatures" :key="feature">
                        <tr>
                            <td class="p-4 font-medium text-gray-800" x-text="feature"></td>
                            <template x-for="vendor in filteredVendors.slice(0, 4)" :key="vendor.id">
                                <td class="text-center p-4">
                                    <div class="flex justify-center">
                                        <div x-show="vendor.features.includes(feature)" class="w-6 h-6 feature-check rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div x-show="!vendor.features.includes(feature)" class="w-6 h-6 feature-cross rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Price Analysis Chart -->
    <div class="mt-12">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Price Analysis</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <canvas id="priceChart" width="400" height="200"></canvas>
                </div>
                <div class="space-y-4">
                    <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-4">
                        <div class="text-sm text-gray-600">Best Value</div>
                        <div class="text-xl font-bold text-green-600" x-text="bestValue.name"></div>
                        <div class="text-sm text-gray-700">Perfect balance of price and features</div>
                    </div>
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-4">
                        <div class="text-sm text-gray-600">Most Features</div>
                        <div class="text-xl font-bold text-purple-600" x-text="mostFeatures.name"></div>
                        <div class="text-sm text-gray-700" x-text="mostFeatures.count + ' features included'"></div>
                    </div>
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg p-4">
                        <div class="text-sm text-gray-600">Budget Friendly</div>
                        <div class="text-xl font-bold text-orange-600" x-text="budgetFriendly.name"></div>
                        <div class="text-sm text-gray-700">R<span x-text="formatNumber(budgetFriendly.savings)"></span> under budget</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for More Info -->
<div x-show="showModal" @click.away="showModal = false" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-screen overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-800" x-text="selectedVendor?.business_name"></h3>
                <button @click="showModal = false" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div x-show="selectedVendor">
                <!-- Complete package details would go here -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-3">Package Includes</h4>
                        <div class="space-y-2">
                            <template x-for="feature in selectedVendor?.all_features || []" :key="feature">
                                <div class="flex items-center text-sm">
                                    <div class="w-4 h-4 feature-check rounded-full flex items-center justify-center mr-2">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span x-text="feature"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-3">Payment Terms</h4>
                        <p class="text-sm text-gray-600 mb-4" x-text="selectedVendor?.payment_terms"></p>
                        
                        <h4 class="font-semibold text-gray-800 mb-3">Contact Information</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center">
                                <span class="w-16 text-gray-500">Email:</span>
                                <span x-text="selectedVendor?.email"></span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-16 text-gray-500">Phone:</span>
                                <span x-text="selectedVendor?.phone"></span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-16 text-gray-500">Location:</span>
                                <span x-text="selectedVendor?.location"></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex gap-4">
                        <button 
                            @click="acceptQuote(selectedVendor); showModal = false"
                            class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white py-3 rounded-lg font-semibold hover:from-green-700 hover:to-green-800 transition-all"
                        >
                            Accept Quote
                        </button>
                        <button 
                            @click="requestMoreInfo(selectedVendor)"
                            class="flex-1 border border-purple-500 text-purple-600 py-3 rounded-lg font-semibold hover:bg-purple-50 transition-colors"
                        >
                            Request More Info
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function comparisonDashboard(data) {
    return {
        showModal: false,
        selectedVendor: null,
        sortBy: 'compatibility_desc',
        budgetFilter: 'all',
        showFeaturesOnly: false,
        quoteRequest: data.quoteRequest,
        vendors: data.vendors,
        filteredVendors: [],
        commonFeatures: [],
        
        init() {
            this.filteredVendors = [...this.vendors];
            this.commonFeatures = this.getCommonFeatures();
            this.sortVendors();
            this.$nextTick(() => {
                this.initPriceChart();
            });
        },

        getCommonFeatures() {
            const allFeatures = this.vendors.reduce((acc, vendor) => {
                vendor.all_features.forEach(feature => {
                    if (!acc.includes(feature)) {
                        acc.push(feature);
                    }
                });
                return acc;
            }, []);
            return allFeatures;
        },

        get averagePrice() {
            if (this.filteredVendors.length === 0) return 0;
            return this.filteredVendors.reduce((sum, vendor) => sum + vendor.quote_amount, 0) / this.filteredVendors.length;
        },

        get averageRating() {
            if (this.filteredVendors.length === 0) return 0;
            return this.filteredVendors.reduce((sum, vendor) => sum + vendor.rating, 0) / this.filteredVendors.length;
        },

        get averageResponseTime() {
            return '18h'; // Simplified for demo
        },

        get bestValue() {
            if (this.filteredVendors.length === 0) return { name: '' };
            return {
                name: this.filteredVendors.find(v => v.compatibility_score > 85 && v.quote_amount < this.averagePrice)?.business_name || 'Dream Day Planners',
            };
        },

        get mostFeatures() {
            if (this.filteredVendors.length === 0) return { name: '', count: 0 };
            const vendorWithMostFeatures = this.filteredVendors.reduce((max, vendor) => 
                vendor.all_features.length > max.all_features.length ? vendor : max
            );
            return {
                name: vendorWithMostFeatures.business_name,
                count: vendorWithMostFeatures.all_features.length
            };
        },

        get budgetFriendly() {
            if (this.filteredVendors.length === 0) return { name: '', savings: 0 };
            const cheapest = this.filteredVendors.reduce((min, vendor) => 
                vendor.quote_amount < min.quote_amount ? vendor : min
            );
            return {
                name: cheapest.business_name,
                savings: this.quoteRequest.budget - cheapest.quote_amount
            };
        },

        sortVendors() {
            switch (this.sortBy) {
                case 'price_asc':
                    this.filteredVendors.sort((a, b) => a.quote_amount - b.quote_amount);
                    break;
                case 'price_desc':
                    this.filteredVendors.sort((a, b) => b.quote_amount - a.quote_amount);
                    break;
                case 'rating_desc':
                    this.filteredVendors.sort((a, b) => b.rating - a.rating);
                    break;
                case 'compatibility_desc':
                    this.filteredVendors.sort((a, b) => b.compatibility_score - a.compatibility_score);
                    break;
                case 'response_time':
                    this.filteredVendors.sort((a, b) => parseInt(a.response_time) - parseInt(b.response_time));
                    break;
            }
        },

        filterVendors() {
            let filtered = [...this.vendors];
            
            // Budget filter
            if (this.budgetFilter === 'within_budget') {
                filtered = filtered.filter(vendor => vendor.quote_amount <= this.quoteRequest.budget);
            } else if (this.budgetFilter === 'slightly_over') {
                filtered = filtered.filter(vendor => vendor.quote_amount <= this.quoteRequest.budget * 1.2);
            }

            // Features filter
            if (this.showFeaturesOnly) {
                filtered = filtered.filter(vendor => vendor.all_features.length >= 8);
            }

            this.filteredVendors = filtered;
            this.sortVendors();
        },

        showFullDetails(vendor) {
            this.selectedVendor = vendor;
            this.showModal = true;
        },

        async acceptQuote(vendor) {
            if (confirm(`Are you sure you want to accept ${vendor.business_name}'s quote for R${this.formatNumber(vendor.quote_amount)}?`)) {
                try {
                    // API call would go here
                    alert(`✅ Great choice! You've accepted ${vendor.business_name}'s quote. They will be notified and will contact you within 24 hours to finalize details.`);
                    // Redirect to booking page
                    window.location.href = `/couple/bookings/create?vendor=${vendor.id}`;
                } catch (error) {
                    alert('Sorry, there was an error. Please try again.');
                }
            }
        },

        async requestMoreInfo(vendor) {
            const message = prompt(`Send a message to ${vendor.business_name}:`, 
                'Hi! I\'m interested in your wedding package and would like to discuss some additional details...');
            
            if (message) {
                try {
                    // API call would go here
                    alert(`📧 Message sent to ${vendor.business_name}! They typically respond within ${vendor.response_time}.`);
                } catch (error) {
                    alert('Sorry, there was an error sending your message. Please try again.');
                }
            }
        },

        async scheduleCall(vendor) {
            alert(`📞 Redirecting you to schedule a call with ${vendor.business_name}...`);
            // Would redirect to calendar booking system
            window.location.href = `/couple/schedule-call?vendor=${vendor.id}`;
        },

        formatNumber(num) {
            return new Intl.NumberFormat().format(num);
        },

        initPriceChart() {
            const ctx = document.getElementById('priceChart').getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: this.filteredVendors.map(v => v.business_name.split(' ')[0]),
                    datasets: [{
                        label: 'Quote Amount',
                        data: this.filteredVendors.map(v => v.quote_amount),
                        backgroundColor: [
                            'rgba(139, 92, 246, 0.8)',
                            'rgba(168, 85, 247, 0.8)', 
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)'
                        ],
                        borderColor: [
                            'rgba(139, 92, 246, 1)',
                            'rgba(168, 85, 247, 1)',
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(245, 158, 11, 1)'
                        ],
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => `R${this.formatNumber(context.raw)}`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: (value) => 'R' + this.formatNumber(value)
                            }
                        }
                    },
                    elements: {
                        bar: {
                            borderRadius: 8
                        }
                    }
                }
            });
        }
    }
}
</script>
@endsection
