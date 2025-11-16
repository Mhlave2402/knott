<?php

namespace App\Jobs;

use App\Models\Contribution;
use App\Models\VendorSubscription;
use App\Models\Booking;
use App\Notifications\PaymentConfirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $paymentIntentId,
        private string $paymentType
    ) {}

    public function handle(): void
    {
        switch ($this->paymentType) {
            case 'gift_well_contribution':
                $this->processGiftWellContribution();
                break;
            case 'vendor_subscription':
                $this->processVendorSubscription();
                break;
            case 'booking_deposit':
                $this->processBookingDeposit();
                break;
        }
    }

    private function processGiftWellContribution(): void
    {
        $contribution = Contribution::where('stripe_payment_intent', $this->paymentIntentId)->first();
        
        if ($contribution && $contribution->status === 'pending_payment') {
            $contribution->update([
                'status' => 'completed',
                'paid_at' => now()
            ]);

            // Update gift well total
            $contribution->giftWell->increment('total_amount', $contribution->amount);

            // Send confirmation email to guest
            if ($contribution->guest_email) {
                // Send notification (implement as needed)
            }

            // Notify couple
            $contribution->giftWell->couple->user->notify(
                new PaymentConfirmation($contribution)
            );
        }
    }

    private function processVendorSubscription(): void
    {
        $subscription = VendorSubscription::where('stripe_payment_intent', $this->paymentIntentId)->first();
        
        if ($subscription && $subscription->status === 'pending_payment') {
            $subscription->update([
                'status' => 'active',
                'activated_at' => now(),
                'expires_at' => now()->addMonth()
            ]);

            // Activate vendor features
            $subscription->vendor->update(['subscription_status' => 'active']);
        }
    }

    private function processBookingDeposit(): void
    {
        $booking = Booking::where('stripe_payment_intent', $this->paymentIntentId)->first();
        
        if ($booking && $booking->status === 'pending_deposit') {
            $booking->update([
                'status' => 'deposit_paid',
                'deposit_paid_at' => now()
            ]);

            // Notify vendor of confirmed booking
            // Notify couple of successful payment
        }
    }
}