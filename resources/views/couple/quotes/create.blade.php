<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>AI Quote Request Wizard - Knott Wedding Platform</title>

    <!-- Tailwind & Alpine (CDN for simplicity) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .step-indicator { transition: all 0.3s ease; }
        .step-indicator.active {
            background: linear-gradient(135deg, #8B5CF6, #A855F7);
            color: white; box-shadow: 0 4px 15px rgba(139,92,246,0.4);
        }
        .step-indicator.completed { background: #10B981; color: white; }
        .form-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0; box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .ai-matching-animation { animation: pulse-glow 2s infinite; }
        @keyframes pulse-glow {
            0%,100% { box-shadow: 0 0 20px rgba(139,92,246,0.3); }
            50% { box-shadow: 0 0 40px rgba(139,92,246,0.6); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-white to-pink-50 min-h-screen">

<!-- Quote Request Wizard -->
<div class="container mx-auto px-4 py-8" x-data="quoteWizard()">
    <!-- Header -->
    <div class="text-center mb-12">
        <div class="flex items-center justify-center mb-6">
            <!-- Knott Logo -->
            <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Knott</h1>
                <p class="text-gray-600 text-sm">AI-Powered Wedding Planning</p>
            </div>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Find Your Perfect Wedding Vendors</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
            Our AI will analyze your requirements and instantly match you with the best wedding vendors.
            Get personalized quotes in minutes!
        </p>
    </div>

    <!-- Progress Steps -->
    <div class="flex justify-center mb-12">
        <div class="flex items-center space-x-4">
            <template x-for="(step, index) in steps" :key="index">
                <div class="flex items-center">
                    <div
                        class="step-indicator w-12 h-12 rounded-full flex items-center justify-center font-semibold text-sm border-2 border-gray-200"
                        :class="{ 'active': currentStep === index + 1, 'completed': currentStep > index + 1, 'bg-gray-100 text-gray-400': currentStep < index + 1 }"
                    >
                        <span x-show="currentStep <= index + 1" x-text="index + 1"></span>
                        <svg x-show="currentStep > index + 1" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div x-show="index < steps.length - 1" class="w-8 h-0.5 bg-gray-200 mx-2">
                        <div class="h-full bg-gradient-to-r from-purple-500 to-pink-500 transition-all duration-300" :style="currentStep > index + 1 ? 'width: 100%' : 'width: 0%'"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="max-w-2xl mx-auto form-card rounded-2xl p-8">
        <form id="quote-form" @submit.prevent="submitForm" action="{{ route('couple.quotes.store') }}" method="POST">
            @csrf

            <!-- Step 1: Basic Details -->
            <div x-show="currentStep === 1" x-transition>
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Let's Start with the Basics</h3>
                    <p class="text-gray-600">Tell us about your dream wedding vision</p>
                </div>

                <div class="space-y-6">
                    <!-- Budget -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">What's your total wedding budget? 💰</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">R</span>
                            <input type="number" x-model.number="formData.budget" name="budget" class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="150000" min="1000" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">This helps us match you with vendors in your price range</p>
                    </div>

                    <!-- Guest Count -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">How many guests will you have? 👥</label>
                        <input type="number" x-model.number="formData.guest_count" name="guest_count" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="120" min="10" max="1000" required>
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Where will your wedding be? 📍</label>
                        <input type="text" x-model.trim="formData.location" name="location" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="e.g., Cape Town, Johannesburg, Durban" required>
                    </div>
                </div>
            </div>

            <!-- Step 2: Style & Preferences -->
            <div x-show="currentStep === 2" x-transition>
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4 4 4 0 004-4V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">What's Your Wedding Style?</h3>
                    <p class="text-gray-600">Choose the style that resonates with your vision</p>
                </div>

                <!-- Wedding Styles Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <template x-for="style in weddingStyles" :key="style.value">
                        <div class="cursor-pointer p-4 rounded-lg border-2 text-center transition-all hover:scale-105"
                             :class="formData.style === style.value ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-purple-300'"
                             @click="formData.style = style.value">
                            <div class="text-2xl mb-2" x-text="style.emoji"></div>
                            <div class="font-medium text-gray-800" x-text="style.label"></div>
                            <div class="text-xs text-gray-500 mt-1" x-text="style.description"></div>
                        </div>
                    </template>
                </div>

                <!-- Preferred Date -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Do you have a preferred date? 📅</label>
                    <input type="date" x-model="formData.preferred_date" name="preferred_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" :min="new Date().toISOString().split('T')[0]">
                    <p class="text-xs text-gray-500 mt-1">Optional - helps vendors check availability</p>
                </div>
            </div>

            <!-- Step 3: Special Requirements & Contact -->
            <div x-show="currentStep === 3" x-transition>
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Any Special Requirements?</h3>
                    <p class="text-gray-600">Help us find vendors who can accommodate your unique needs</p>
                </div>

                <div class="space-y-6">
                    <!-- Special Requirements -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tell us about any special requirements ✨</label>
                        <textarea x-model.trim="formData.special_requirements" name="special_requirements" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" rows="4" placeholder="e.g., Dietary restrictions, accessibility needs, cultural traditions, specific color schemes..."></textarea>
                    </div>

                    <!-- Timeline Urgency -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">How urgent is your timeline? ⏰</label>
                        <input type="hidden" name="urgency" :value="formData.urgency">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div class="cursor-pointer p-4 border-2 rounded-lg text-center transition-all"
                                 :class="formData.urgency === 'flexible' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'"
                                 @click="formData.urgency = 'flexible'">
                                <div class="text-green-600 font-medium">Flexible</div>
                                <div class="text-sm text-gray-600">6+ months away</div>
                            </div>
                            <div class="cursor-pointer p-4 border-2 rounded-lg text-center transition-all"
                                 :class="formData.urgency === 'moderate' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300'"
                                 @click="formData.urgency = 'moderate'">
                                <div class="text-yellow-600 font-medium">Moderate</div>
                                <div class="text-sm text-gray-600">3-6 months away</div>
                            </div>
                            <div class="cursor-pointer p-4 border-2 rounded-lg text-center transition-all"
                                 :class="formData.urgency === 'urgent' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-red-300'"
                                 @click="formData.urgency = 'urgent'">
                                <div class="text-red-600 font-medium">Urgent</div>
                                <div class="text-sm text-gray-600">Less than 3 months</div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Preference -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">How should vendors contact you? 📞</label>
                        <input type="hidden" name="contact_preference" :value="formData.contact_preference">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div class="cursor-pointer p-4 border-2 rounded-lg text-center transition-all"
                                 :class="formData.contact_preference === 'email' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300'"
                                 @click="formData.contact_preference = 'email'">
                                <div class="text-blue-600 font-medium">📧 Email</div>
                                <div class="text-sm text-gray-600">Professional & organized</div>
                            </div>
                            <div class="cursor-pointer p-4 border-2 rounded-lg text-center transition-all"
                                 :class="formData.contact_preference === 'phone' ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-purple-300'"
                                 @click="formData.contact_preference = 'phone'">
                                <div class="text-purple-600 font-medium">📞 Phone Call</div>
                                <div class="text-sm text-gray-600">Direct conversation</div>
                            </div>
                            <div class="cursor-pointer p-4 border-2 rounded-lg text-center transition-all"
                                 :class="formData.contact_preference === 'whatsapp' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'"
                                 @click="formData.contact_preference = 'whatsapp'">
                                <div class="text-green-600 font-medium">💬 WhatsApp</div>
                                <div class="text-sm text-gray-600">Quick & convenient</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: AI Matching Process -->
            <div x-show="currentStep === 4" x-transition>
                <div class="text-center">
                    <!-- AI Matching Animation -->
                    <div x-show="!matchingComplete" class="mb-8">
                        <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 ai-matching-animation">
                            <svg class="w-12 h-12 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">AI is Finding Your Perfect Vendors</h3>
                        <p class="text-gray-600 mb-6">Our intelligent system is analyzing your requirements and matching you with the best wedding vendors...</p>

                        <!-- Progress Steps -->
                        <div class="max-w-md mx-auto">
                            <div class="space-y-4">
                                <div class="flex items-center" :class="aiStep >= 1 ? 'text-green-600' : 'text-gray-400'">
                                    <div class="w-6 h-6 rounded-full mr-3 flex items-center justify-center" :class="aiStep >= 1 ? 'bg-green-100' : 'bg-gray-100'">
                                        <svg x-show="aiStep >= 1" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <div x-show="aiStep < 1" class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                                    </div>
                                    <span>Processing your requirements</span>
                                </div>
                                <div class="flex items-center" :class="aiStep >= 2 ? 'text-green-600' : 'text-gray-400'">
                                    <div class="w-6 h-6 rounded-full mr-3 flex items-center justify-center" :class="aiStep >= 2 ? 'bg-green-100' : 'bg-gray-100'">
                                        <svg x-show="aiStep >= 2" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <div x-show="aiStep < 2" class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                                    </div>
                                    <span>Analyzing vendor database</span>
                                </div>
                                <div class="flex items-center" :class="aiStep >= 3 ? 'text-green-600' : 'text-gray-400'">
                                    <div class="w-6 h-6 rounded-full mr-3 flex items-center justify-center" :class="aiStep >= 3 ? 'bg-green-100' : 'bg-gray-100'">
                                        <svg x-show="aiStep >= 3" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <div x-show="aiStep < 3" class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                                    </div>
                                    <span>Calculating compatibility scores</span>
                                </div>
                                <div class="flex items-center" :class="aiStep >= 4 ? 'text-green-600' : 'text-gray-400'">
                                    <div class="w-6 h-6 rounded-full mr-3 flex items-center justify-center" :class="aiStep >= 4 ? 'bg-green-100' : 'bg-gray-100'">
                                        <svg x-show="aiStep >= 4" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <div x-show="aiStep < 4" class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                                    </div>
                                    <span>Sending quote requests to vendors</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success State -->
                    <div x-show="matchingComplete" x-transition class="text-center">
                        <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Perfect Match Found! 🎉</h3>
                        <p class="text-gray-600 mb-6">We found <span class="font-semibold text-purple-600" x-text="matchResults.vendors_count"></span> amazing vendors that match your requirements!</p>

                        <!-- Match Summary -->
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 mb-8">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-purple-600" x-text="matchResults.vendors_count || '8'"></div>
                                    <div class="text-sm text-gray-600">Vendors Matched</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-pink-600" x-text="matchResults.avg_compatibility || '87'"></div>
                                    <div class="text-sm text-gray-600">Avg Compatibility</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600" x-text="matchResults.processing_time || '<2'"></div>
                                    <div class="text-sm text-gray-600">Minutes to Match</div>
                                </div>
                            </div>
                        </div>

                        <!-- Next Steps -->
                        <div class="bg-white border-2 border-gray-100 rounded-xl p-6">
                            <h4 class="font-semibold text-gray-800 mb-4">What happens next?</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3 mt-1">
                                        <span class="text-purple-600 font-semibold">1</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">Vendors Respond</div>
                                        <div class="text-gray-600">Matched vendors will send you personalized quotes within 24-48 hours</div>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center mr-3 mt-1">
                                        <span class="text-pink-600 font-semibold">2</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">Compare & Choose</div>
                                        <div class="text-gray-600">Review quotes side-by-side and select your favorites</div>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3 mt-1">
                                        <span class="text-green-600 font-semibold">3</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">Book & Plan</div>
                                        <div class="text-gray-600">Secure your vendors and start planning your perfect day</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                <button type="button" @click="previousStep()" x-show="currentStep > 1 && currentStep < 4" class="flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Previous
                </button>

                <div class="flex-1"></div>

                <button type="button" @click="nextStep()" x-show="currentStep < 3" class="flex items-center px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105 shadow-lg">
                    <span x-show="currentStep < 3">Next Step</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <button type="submit" x-show="currentStep === 3" :disabled="isSubmitting" class="flex items-center px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105 shadow-lg disabled:opacity-50">
                    <svg x-show="isSubmitting" class="animate-spin w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span x-show="!isSubmitting">Find My Vendors</span>
                    <span x-show="isSubmitting">Processing...</span>
                </button>

                <button type="button" @click="goToDashboard()" x-show="matchingComplete" class="flex items-center px-8 py-3 bg-gradient-to-r from-green-600 to-blue-600 text-white rounded-lg hover:from-green-700 hover:to-blue-700 transition-all transform hover:scale-105 shadow-lg">
                    View My Matches
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Help Section -->
    <div class="max-w-2xl mx-auto mt-12 text-center">
        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Need Help? We're Here! 💬</h3>
            <p class="text-gray-600 mb-4">Our wedding planning experts are available to assist you with any questions.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:support@knott.co.za" class="flex items-center justify-center px-6 py-3 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Email Support
                </a>
                <a href="https://wa.me/27123456789" target="_blank" rel="noopener" class="flex items-center justify-center px-6 py-3 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>
                    WhatsApp Chat
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function quoteWizard() {
    return {
        currentStep: 1,
        isSubmitting: false,
        matchingComplete: false,
        aiStep: 0,
        quoteRequestId: null,
        formData: {
            budget: '',
            guest_count: '',
            location: '',
            preferred_date: '',
            style: '',
            special_requirements: '',
            urgency: '',
            contact_preference: ''
        },
        matchResults: {
            vendors_count: 0,
            avg_compatibility: 0,
            processing_time: 0
        },
        steps: [
            { title: 'Basic Details', description: 'Budget, guests, location' },
            { title: 'Style & Date', description: 'Wedding style and preferences' },
            { title: 'Requirements', description: 'Special needs and timeline' },
            { title: 'AI Matching', description: 'Finding perfect vendors' }
        ],
        weddingStyles: [
            { value: 'vintage', label: 'Vintage', emoji: '🕰️', description: 'Classic & timeless' },
            { value: 'modern', label: 'Modern', emoji: '✨', description: 'Clean & contemporary' },
            { value: 'rustic', label: 'Rustic', emoji: '🌾', description: 'Natural & cozy' },
            { value: 'elegant', label: 'Elegant', emoji: '👑', description: 'Sophisticated & refined' },
            { value: 'traditional', label: 'Traditional', emoji: '💒', description: 'Time-honored customs' },
            { value: 'bohemian', label: 'Bohemian', emoji: '🌸', description: 'Free-spirited & artistic' },
            { value: 'minimalist', label: 'Minimalist', emoji: '⚪', description: 'Simple & clean' },
            { value: 'glamorous', label: 'Glamorous', emoji: '💎', description: 'Luxurious & sparkly' }
        ],

        nextStep() {
            if (this.validateCurrentStep()) this.currentStep++;
        },
        previousStep() {
            if (this.currentStep > 1) this.currentStep--;
        },
        validateCurrentStep() {
            switch (this.currentStep) {
                case 1:
                    return !!(this.formData.budget && this.formData.guest_count && this.formData.location);
                case 2:
                    return !!this.formData.style;
                case 3:
                    return !!(this.formData.urgency && this.formData.contact_preference);
                default:
                    return true;
            }
        },

        async submitForm() {
            if (!this.validateCurrentStep()) return;
            this.isSubmitting = true;
            this.currentStep = 4; // show AI matching screen

            await this.simulateAIMatching(); // show animated steps while backend works

            try {
                const url = document.getElementById('quote-form').getAttribute('action');
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.formData)
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    this.quoteRequestId = result.quote_request_id;
                    this.matchResults = {
                        vendors_count: result.matches_count ?? 8,
                        avg_compatibility: 87,
                        processing_time: 2
                    };
                    this.matchingComplete = true;
                } else {
                    throw new Error(result.message || 'Something went wrong');
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                alert('Sorry, something went wrong. Please try again.');
                // allow user to go back and edit
                this.currentStep = 3;
            } finally {
                this.isSubmitting = false;
            }
        },

        async simulateAIMatching() {
            const steps = [1, 2, 3, 4];
            for (let step of steps) {
                await new Promise(resolve => setTimeout(resolve, 900));
                this.aiStep = step;
            }
        },

        goToDashboard() {
            if (this.quoteRequestId) {
                window.location.href = `/couple/quotes/${this.quoteRequestId}`;
            } else {
                window.location.href = '/couple/dashboard';
            }
        }
    }
}
</script>

</body>
</html>
