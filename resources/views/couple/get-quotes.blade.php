// resources/views/couple/get-quotes.blade.php
<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                <span>Step <span id="current-step">1</span> of 4</span>
                <span><span id="progress-percent">25</span>% Complete</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div id="progress-bar" class="bg-purple-600 h-2 rounded-full transition-all duration-300" style="width: 25%"></div>
            </div>
        </div>

        <!-- Step 1: Event Details -->
        <div id="step-1" class="step active">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Tell us about your special day</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Event Date</label>
                        <input type="date" name="event_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Guest Count</label>
                        <select name="guest_count" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option>50-75 guests</option>
                            <option>75-100 guests</option>
                            <option>100-150 guests</option>
                            <option>150-200 guests</option>
                            <option>200+ guests</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Venue Location</label>
                        <input type="text" name="venue_location" placeholder="e.g., Johannesburg, Cape Town" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Budget Breakdown -->
        <div id="step-2" class="step hidden">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Budget Allocation</h2>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Wedding Budget</label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">R</span>
                        <input type="number" id="total-budget" class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="100000">
                    </div>
                </div>
                
                <!-- Budget Categories -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="budget-categories">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-8">
            <button id="prev-btn" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors hidden">Previous</button>
            <button id="next-btn" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">Next</button>
            <button id="submit-btn" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors hidden">Get My Matches</button>
        </div>
    </div>

    @push('scripts')
    <script>
        const budgetCategories = [
            {name: 'Photography', key: 'photography', suggested: 15},
            {name: 'Videography', key: 'videography', suggested: 10},
            {name: 'Catering', key: 'catering', suggested: 30},
            {name: 'Venue', key: 'venue', suggested: 25},
            {name: 'Flowers & Decor', key: 'flowers', suggested: 10},
            {name: 'Music & DJ', key: 'music', suggested: 5},
            {name: 'Transportation', key: 'transport', suggested: 3},
            {name: 'Other', key: 'other', suggested: 2}
        ];
        
        // Step navigation logic
        let currentStep = 1;
        const totalSteps = 4;
        
        function updateProgress() {
            document.getElementById('current-step').textContent = currentStep;
            document.getElementById('progress-percent').textContent = (currentStep / totalSteps) * 100;
            document.getElementById('progress-bar').style.width = `${(currentStep / totalSteps) * 100}%`;
        }
        
        // Budget distribution
        function populateBudgetCategories() {
            const container = document.getElementById('budget-categories');
            const totalBudget = parseInt(document.getElementById('total-budget').value) || 100000;
            
            budgetCategories.forEach(category => {
                const suggestedAmount = (totalBudget * category.suggested) / 100;
                container.innerHTML += `
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium">${category.name}</span>
                            <span class="text-sm text-gray-500">${category.suggested}%</span>
                        </div>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500">R</span>
                            <input type="number" name="budget_${category.key}" value="${suggestedAmount}" class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 budget-input">
                        </div>
                    </div>
                `;
            });
        }
        
        document.getElementById('total-budget').addEventListener('input', function() {
            document.getElementById('budget-categories').innerHTML = '';
            populateBudgetCategories();
        });
    </script>
    @endpush
</x-app-layout>