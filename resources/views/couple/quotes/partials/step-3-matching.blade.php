<div class="bg-white rounded-xl shadow-lg p-8 text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-4">Finding Your Perfect Vendors...</h2>
    <p class="text-gray-600 mb-6">Our AI is analyzing your wedding details and selected services</p>

    <div class="relative w-full h-6 bg-gray-200 rounded-full overflow-hidden">
        <div class="absolute left-0 top-0 h-full bg-purple-600 rounded-full transition-all duration-1000"
             :style="'width: ' + matchingProgress + '%'"></div>
    </div>

    <p class="mt-4 text-gray-700" x-text="matchingProgress + '%'"></p>
</div>
