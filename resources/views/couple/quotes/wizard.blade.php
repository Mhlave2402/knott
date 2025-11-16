<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get AI-Powered Vendor Matches - Knott</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Your existing CSS goes here */
    </style>
</head>
<body class="bg-gray-50">
    <div x-data="quoteWizard()" class="min-h-screen">

        <!-- Header & Progress Steps (keep your existing code here) -->

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Step 1: Wedding Details -->
            <div x-show="currentStep === 1" class="slide-in">
                @include('couples.quotes.partials.step-1-details')
            </div>

            <!-- Step 2: Service Selection -->
            <div x-show="currentStep === 2" class="slide-in">
                @include('couples.quotes.partials.step-2-services')
            </div>

            <!-- Step 3: AI Matching -->
            <div x-show="currentStep === 3" class="slide-in">
                @include('couples.quotes.partials.step-3-matching')
            </div>

            <!-- Step 4: Vendor Results -->
            <div x-show="currentStep === 4" class="slide-in">
                @include('couples.quotes.partials.step-4-results')
            </div>
        </div>
    </div>

    <!-- Alpine.js script (quoteWizard function) -->
    <script>
        function quoteWizard() {
            return {
                currentStep: 1,
                isSubmitting: false,
                showSuccessModal: false,
                matchingComplete: false,
                /* ...rest of your Alpine.js logic here... */
            }
        }
    </script>
</body>
</html>
