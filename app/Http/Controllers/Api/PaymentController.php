<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use App\Models\VendorSubscription;
use App\Models\Booking;
use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function __construct(
        private PaymentService $paymentService
    ) {}

    public function processVendorSubscription(Request $request): JsonResponse
    {
        $subscription = VendorSubscription::findOrFail($request->subscription_id);
        
        $result = $this->paymentService->processVendorSubscription($subscription);
        
        return response()->json($result);
    }

    public function processBookingDeposit(Request $request): JsonResponse
    {
        $booking = Booking::findOrFail($request->booking_id);
        
        $result = $this->paymentService->processBookingDeposit($booking);
        
        return response()->json($result);
    }

    public function processGiftWellContribution(Request $request): JsonResponse
    {
        $contribution = Contribution::findOrFail($request->contribution_id);
        
        $result = $this->paymentService->processGiftWellContribution($contribution);
        
        return response()->json($result);
    }

    public function handleWebhook(Request $request): JsonResponse
    {
        $signature = $request->header('Stripe-Signature');
        $payload = $request->getContent();
        
        $success = $this->paymentService->handleWebhook(
            json_decode($payload, true),
            $signature
        );
        
        return response()->json(['success' => $success]);
    }
}