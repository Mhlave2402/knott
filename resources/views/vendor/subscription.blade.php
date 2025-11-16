@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800">Choose Your Plan</h1>
        <p class="text-lg text-gray-600 mt-2">Select the best plan for your business needs.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Professional Plan -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-purple-500 relative">
            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                <span class="bg-purple-500 text-white px-4 py-1 rounded-full text-sm font-semibold">Most Popular</span>
            </div>
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Professional</h3>
                <div class="text-4xl font-bold text-purple-600 mb-4">R79<span class="text-lg font-normal text-gray-500">/month</span></div>
                <p class="text-gray-600">For growing businesses</p>
            </div>
            <ul class="space-y-4 mb-8">
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Everything in Starter
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Unlimited portfolio images
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Priority AI matching
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Advanced analytics
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Featured in search results
                </li>
            </ul>
            <button onclick="subscribeToPlan('professional', 79)" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                Choose Professional
            </button>
        </div>

        <!-- Premium Plan -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Premium</h3>
                <div class="text-4xl font-bold text-purple-600 mb-4">R149<span class="text-lg font-normal text-gray-500">/month</span></div>
                <p class="text-gray-600">For established businesses</p>
            </div>
            <ul class="space-y-4 mb-8">
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Everything in Professional
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Premium badge & top placement
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Competition entry privileges
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Dedicated account manager
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Custom marketing tools
                </li>
            </ul>
            <button onclick="subscribeToPlan('premium', 149)" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                Go Premium
            </button>
        </div>
    </div>

    <!-- Current Subscription Status -->
    @if(auth()->user()->vendor->subscription)
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Current Subscription</h3>
        <div class="flex items-center justify-between">
            <div>
                <span class="text-lg font-semibold text-purple-600">{{ ucfirst(auth()->user()->vendor->subscription->plan) }} Plan</span>
                <p class="text-gray-600">Next billing: {{ auth()->user()->vendor->subscription->expires_at->format('M j, Y') }}</p>
            </div>
            <div class="text-right">
                <span class="text-2xl font-bold text-gray-900">R{{ auth()->user()->vendor->subscription->amount }}</span>
                <p class="text-gray-600">per month</p>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Payment Modal --}}
<div id="payment-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">Complete Your Subscription</h3>
        <div id="payment-form">
            <div id="card-element" class="p-4 border border-gray-300 rounded-lg mb-4">
                <!-- Stripe Elements will create form elements here -->
            </div>
            <div id="card-errors" class="text-red-600 mb-4" role="alert"></div>
            
            <button id="submit-payment" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                Subscribe Now
            </button>
        </div>
        
        <button onclick="closePaymentModal()" class="w-full mt-4 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-2 px-6 rounded-lg transition duration-200">
            Cancel
        </button>
    </div>
</div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config("payment.stripe.key") }}');
    const elements = stripe.elements();
    let currentPlan = null;
    let currentAmount = null;

    // Create card element
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#424770',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
        },
    });

    cardElement.mount('#card-element');

    function subscribeToPlan(plan, amount) {
        currentPlan = plan;
        currentAmount = amount;
        document.getElementById('modal-plan-name').textContent = `Subscribe to ${plan.charAt(0).toUpperCase() + plan.slice(1)} Plan`;
        document.getElementById('modal-plan-price').textContent = `Amount: R${amount}/month`;
        document.getElementById('payment-modal').classList.remove('hidden');
    }

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const { paymentMethod, error } = await stripe.createPaymentMethod('card', cardElement);

        if (error) {
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
        } else {
            // Send paymentMethod.id to your server
            fetch('/vendor/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    plan: currentPlan,
                    amount: currentAmount,
                    payment_method: paymentMethod.id,
                }),
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      window.location.reload();
                  } else {
                      alert('Subscription failed: ' + data.message);
                  }
              });
        }
    });
</script>
@endsection
