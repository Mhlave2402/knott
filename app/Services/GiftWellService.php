<?php

namespace App\Services;

use App\Models\GiftWell;
use App\Models\Contribution;
use App\Models\Couple;
use Illuminate\Support\Str;

class GiftWellService
{
    /**
     * Create a new gift well for couple
     */
    public function createGiftWell(Couple $couple, array $data): GiftWell
    {
        return GiftWell::create([
            'couple_id' => $couple->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'target_amount' => $data['target_amount'] ?? null,
            'wedding_date' => $data['wedding_date'],
            'is_public' => $data['is_public'] ?? true,
            'thank_you_message' => $data['thank_you_message'] ?? 'Thank you for your generous contribution!',
            'status' => 'active'
        ]);
    }

    /**
     * Process gift well withdrawal
     */
    public function processWithdrawal(GiftWell $giftWell): array
    {
        if ($giftWell->status !== 'active' || $giftWell->total_amount <= 0) {
            return [
                'success' => false,
                'error' => 'Invalid gift well status or no funds available'
            ];
        }

        $withdrawalFee = $giftWell->total_amount * config('payment.fees.gift_well_withdrawal_fee');
        $withdrawableAmount = $giftWell->total_amount - $withdrawalFee;

        // Update gift well status
        $giftWell->update([
            'status' => 'withdrawn',
            'withdrawal_fee' => $withdrawalFee
        ]);

        // Here you would integrate with your bank transfer system
        // For now, we'll just log the withdrawal

        return [
            'success' => true,
            'withdrawal_amount' => $withdrawableAmount,
            'fee' => $withdrawalFee,
            'total_contributions' => $giftWell->total_amount
        ];
    }

    /**
     * Generate thank you messages for contributors
     */
    public function generateThankYouMessages(GiftWell $giftWell): void
    {
        $contributions = $giftWell->contributions()->where('status', 'completed')->get();

        foreach ($contributions as $contribution) {
            if (!$contribution->is_anonymous && $contribution->guest_email) {
                // Send personalized thank you email
                // This would integrate with your notification system
            }
        }
    }

    /**
     * Get gift well statistics
     */
    public function getStatistics(GiftWell $giftWell): array
    {
        $contributions = $giftWell->contributions()->where('status', 'completed');

        return [
            'total_contributors' => $contributions->count(),
            'average_contribution' => $contributions->avg('amount'),
            'largest_contribution' => $contributions->max('amount'),
            'recent_contributions' => $contributions->latest()->limit(5)->get(),
            'progress_percentage' => $giftWell->progress_percentage,
            'total_fees_collected' => $contributions->sum('guest_fee')
        ];
    }
}