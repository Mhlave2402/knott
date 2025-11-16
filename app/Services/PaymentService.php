<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Contribution;
use App\Models\VendorSubscription;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('payment.stripe.secret'));
    }

    /**
     * Process vendor subscription payment
     */
    public function processVendorSubscription(VendorSubscription $subscription): array
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $subscription->amount * 100, // Convert to cents
                'currency' => 'zar',
                'metadata' => [
                    'type' => 'vendor_subscription',
                    'subscription_id' => $subscription->id,
                    'vendor_id' => $subscription->vendor_id,
                ],
                'description' => "Knott Vendor Subscription - {$subscription->plan}",
            ]);

            $subscription->update([
                'stripe_payment_intent' => $paymentIntent->id,
                'status' => 'pending_payment'
            ]);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id
            ];

        } catch (Exception $e) {
            Log::error('Vendor subscription payment failed', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Process vendor booking deposit
     */
    public function processBookingDeposit(Booking $booking): array
    {
        try {
            $depositAmount = $booking->total_amount * ($booking->deposit_percentage / 100);
            $platformFee = $depositAmount * 0.05; // 5% platform commission
            
            $paymentIntent = PaymentIntent::create([
                'amount' => ($depositAmount + $platformFee) * 100,
                'currency' => 'zar',
                'metadata' => [
                    'type' => 'booking_deposit',
                    'booking_id' => $booking->id,
                    'vendor_id' => $booking->vendor_id,
                    'couple_id' => $booking->couple_id,
                ],
                'description' => "Knott Booking Deposit - {$booking->vendor->business_name}",
                'application_fee_amount' => $platformFee * 100,
            ]);

            $booking->update([
                'stripe_payment_intent' => $paymentIntent->id,
                'deposit_amount' => $depositAmount,
                'platform_fee' => $platformFee,
                'status' => 'pending_deposit'
            ]);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'deposit_amount' => $depositAmount,
                'platform_fee' => $platformFee
            ];

        } catch (Exception $e) {
            Log::error('Booking deposit payment failed', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Process Gift Well contribution
     */
    public function processGiftWellContribution(Contribution $contribution): array
    {
        try {
            $guestFee = $contribution->amount * 0.10; // 10% guest fee
            $totalAmount = $contribution->amount + $guestFee;

            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount * 100,
                'currency' => 'zar',
                'metadata' => [
                    'type' => 'gift_well_contribution',
                    'contribution_id' => $contribution->id,
                    'gift_well_id' => $contribution->gift_well_id,
                    'guest_name' => $contribution->guest_name,
                ],
                'description' => "Gift Well Contribution - {$contribution->giftWell->couple->user->name}",
            ]);

            $contribution->update([
                'stripe_payment_intent' => $paymentIntent->id,
                'guest_fee' => $guestFee,
                'total_paid' => $totalAmount,
                'status' => 'pending_payment'
            ]);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'guest_fee' => $guestFee,
                'total_amount' => $totalAmount
            ];

        } catch (Exception $e) {
            Log::error('Gift well contribution failed', [
                'contribution_id' => $contribution->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Handle Stripe webhooks
     */
    public function handleWebhook(array $payload, string $signature): bool
    {
        try {
            $event = Webhook::constructEvent(
                json_encode($payload),
                $signature,
                config('payment.stripe.webhook_secret')
            );

            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $this->handleSuccessfulPayment($event->data->object);
                    break;
                case 'payment_intent.payment_failed':
                    $this->handleFailedPayment($event->data->object);
                    break;
            }

            return true;

        } catch (Exception $e) {
            Log::error('Stripe webhook failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    private function handleSuccessfulPayment($paymentIntent)
    {
        $metadata = $paymentIntent->metadata;

        switch ($metadata->type) {
            case 'vendor_subscription':
                $this->activateVendorSubscription($metadata->subscription_id);
                break;
            case 'booking_deposit':
                $this->confirmBookingDeposit($metadata->booking_id);
                break;
            case 'gift_well_contribution':
                $this->confirmGiftWellContribution($metadata->contribution_id);
                break;
        }
    }

    private function activateVendorSubscription(string $subscriptionId)
    {
        $subscription = VendorSubscription::find($subscriptionId);
        $subscription->update([
            'status' => 'active',
            'activated_at' => now(),
            'expires_at' => now()->addMonth()
        ]);
    }

    private function confirmBookingDeposit(string $bookingId)
    {
        $booking = Booking::find($bookingId);
        $booking->update([
            'status' => 'deposit_paid',
            'deposit_paid_at' => now()
        ]);
    }

    private function confirmGiftWellContribution(string $contributionId)
    {
        $contribution = Contribution::find($contributionId);
        $contribution->update([
            'status' => 'completed',
            'paid_at' => now()
        ]);

        // Update gift well total
        $contribution->giftWell->increment('total_amount', $contribution->amount);
    }
}