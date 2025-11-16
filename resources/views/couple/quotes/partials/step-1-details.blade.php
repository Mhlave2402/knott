<div class="bg-white rounded-xl shadow-lg p-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Tell us about your dream wedding</h2>
        <p class="text-gray-600">We'll use AI to find the perfect vendors for your special day</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <!-- Wedding Date -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-calendar-alt mr-2 text-purple-600"></i>
                Wedding Date
            </label>
            <input type="date" 
                   x-model="formData.weddingDate"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
        </div>

        <!-- Guest Count -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-users mr-2 text-purple-600"></i>
                Expected Guest Count
            </label>
            <select x-model="formData.guestCount" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                <option value="">Select guest count</option>
                <option value="intimate">Intimate (1-50 guests)</option>
                <option value="medium">Medium (51-150 guests)</option>
                <option value="large">Large (151-300 guests)</option>
                <option value="grand">Grand (300+ guests)</option>
            </select>
        </div>

        <!-- Location & Budget similar structure... -->
    </div>

    <!-- Wedding Style & Notes -->
    <!-- Continue copying only the content inside this step -->

    <div class="flex justify-end mt-8">
        <button @click="nextStep()" 
                :disabled="!canProceedStep1()"
                class="px-8 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-all duration-300">
            Continue to Services
            <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</div>
