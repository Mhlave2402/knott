<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\GiftWell;
use App\Models\Contribution;
use App\Services\PaymentService;
use App\Http\Requests\ContributionRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ContributionController extends Controller
{
    public function __construct(
        private PaymentService $paymentService
    ) {}

    public function show(string $giftWellId): View
    {
        $giftWell = GiftWell::where('id', $giftWellId)
            ->where('is_public', true)
            ->where('status', 'active')
            ->firstOrFail();

        $recentContributions = $giftWell->contributions()
            ->where('status', 'completed')
            ->latest()
            ->limit(10)
            ->get();

        return view('guests.gift-well.show', compact('giftWell', 'recentContributions'));
    }

    public function contribute(ContributionRequest $request, GiftWell $giftWell): JsonResponse
    {
        $contribution = Contribution::create([
            'gift_well_id' => $giftWell->id,
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'guest_phone' => $request->guest_phone,
            'amount' => $request->amount,
            'message' => $request->message,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'status' => 'pending_payment'
        ]);

        $result = $this->paymentService->processGiftWellContribution($contribution);

        return response()->json($result);
    }

    public function receipt(Contribution $contribution): View
    {
        if ($contribution->status !== 'completed') {
            abort(404);
        }

        return view('guests.gift-well.receipt', compact('contribution'));
    }
}