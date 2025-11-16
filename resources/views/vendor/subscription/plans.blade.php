@extends('layouts.dashboard')

@section('title', 'Subscription Plans')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Choose Your Plan</h1>
            <p class="text-xl text-gray-600">Grow your wedding business with Knott</p>
        </div>

        <!-- Pricing Plans -->
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <!-- Starter Plan -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Starter</h3>
                    <div class="text-4xl font-bold text-purple-600 mb-4">R29<span class="text-lg font-normal text-gray-500">/month</span></div>
                    <p class="text-gray-600">Perfect for new vendors</p>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Basic vendor profile
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Up to 10 portfolio images
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        AI quote requests
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Basic analytics
                    </li>
                </ul>
                <button onclick="closeSuccessModal()" 
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
            Close
        </button>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config("payment.stripe.key") }}');
    const elements = stripe.elements();
    
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

    // Amount calculation
    document.getElementById('amount').addEventListener('input', function(e) {
        const amount = parseFloat(e.target.value) || 0;
        const fee = Math.round(amount * 0.10 * 100) / 100;
        const total = amount + fee;
        
        if (amount > 0) {
            document.getElementById('fee-amount').textContent = fee.toFixed(2);
            document.getElementById('total-amount').textContent = total.toFixed(2);
            document.getElementById('fee-display').classList.remove('hidden');
        } else {
            document.getElementById('fee-display').classList.add('hidden');
        }
    });

    // Form submission
    document.getElementById('contribution-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitButton = document.getElementById('submit-button');
        const buttonText = document.getElementById('button-text');
        const loadingSpinner = document.getElementById('loading-spinner');
        
        // Show loading state
        submitButton.disabled = true;
        buttonText.classList.add('hidden');
        loadingSpinner.classList.remove('hidden');

        try {
            // Create contribution record
            const formData = new FormData(e.target);
            const response = await fetch('{{ route("guests.gift-well.contribute", $giftWell) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
            });

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.error || 'Payment failed');
            }

            // Confirm payment with Stripe
            const { error, paymentIntent } = await stripe.confirmCardPayment(result.client_secret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: document.getElementById('guest_name').value,
                        email: document.getElementById('guest_email').value,
                    },
                }
            });

            if (error) {
                throw new Error(error.message);
            }

            if (paymentIntent.status === 'succeeded') {
                // Show success modal
                document.getElementById('success-modal').classList.remove('hidden');
                
                // Reset form
                e.target.reset();
                document.getElementById('fee-display').classList.add('hidden');
                cardElement.clear();
            }

        } catch (error) {
            document.getElementById('card-errors').textContent = error.message;
        } finally {
            // Reset button state
            submitButton.disabled = false;
            buttonText.classList.remove('hidden');
            loadingSpinner.classList.add('hidden');
        }
    });

    function closeSuccessModal() {
        document.getElementById('success-modal').classList.add('hidden');
        // Optionally reload page to show updated totals
        window.location.reload();
    }
</script>
@endsection