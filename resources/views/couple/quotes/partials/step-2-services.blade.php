<div class="bg-white rounded-xl shadow-lg p-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Select Your Services</h2>
        <p class="text-gray-600">Choose the wedding services you want us to match with vendors</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <template x-for="service in availableServices" :key="service.id">
            <div class="flex items-center p-4 border rounded-lg cursor-pointer hover:ring-2 hover:ring-purple-600 transition-all"
                 :class="formData.services.includes(service.id) ? 'bg-purple-50 border-purple-300' : ''"
                 @click="toggleService(service.id)">
                <i class="fas fa-check-circle mr-3 text-purple-600" x-show="formData.services.includes(service.id)"></i>
                <span x-text="service.name"></span>
            </div>
        </template>
    </div>

    <div class="flex justify-between mt-8">
        <button @click="prevStep()" class="px-6 py-3 bg-gray-200 rounded-lg font-semibold hover:bg-gray-300 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </button>
        <button @click="nextStep()" :disabled="formData.services.length === 0"
                class="px-8 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-all">
            Find Vendors <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</div>
