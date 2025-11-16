<div class="bg-white rounded-xl shadow-lg p-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Your Matched Vendors</h2>
        <p class="text-gray-600">Here are the vendors best suited for your wedding</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <template x-for="vendor in matchedVendors" :key="vendor.id">
            <div class="p-4 border rounded-lg hover:shadow-lg transition-all">
                <h3 class="font-semibold text-lg" x-text="vendor.name"></h3>
                <p class="text-gray-600" x-text="vendor.category"></p>
                <p class="text-gray-800 mt-2" x-text="vendor.description"></p>
                <div class="mt-4 flex justify-between items-center">
                    <span class="text-purple-600 font-semibold" x-text="'R' + vendor.price"></span>
                    <button @click="selectVendor(vendor.id)" class="px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition-all">
                        Select
                    </button>
                </div>
            </div>
        </template>
    </div>

    <div class="flex justify-end mt-8">
        <button @click="prevStep()" class="px-6 py-3 bg-gray-200 rounded-lg font-semibold hover:bg-gray-300 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </button>
    </div>
</div>
