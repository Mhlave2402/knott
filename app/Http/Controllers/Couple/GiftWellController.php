<?php

namespace App\Http\Controllers\Couple;

use App\Http\Controllers\Controller;
use App\Services\GiftWellService;
use App\Http\Requests\GiftWellRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GiftWellController extends Controller
{
    public function __construct(
        private GiftWellService $giftWellService
    ) {}

    public function index(): View
    {
        $couple = auth()->user()->couple;
        $giftWells = $couple->giftWells()->with('contributions')->latest()->get();

        return view('couples.gift-well.index', compact('giftWells'));
    }

    public function create(): View
    {
        return view('couples.gift-well.create');
    }

    public function store(GiftWellRequest $request): RedirectResponse
    {
        $couple = auth()->user()->couple;
        
        $giftWell = $this->giftWellService->createGiftWell($couple, $request->validated());

        return redirect()->route('couples.gift-well.show', $giftWell)
            ->with('success', 'Gift Well created successfully!');
    }

    public function show(GiftWell $giftWell): View
    {
        $this->authorize('view', $giftWell);
        
        $statistics = $this->giftWellService->getStatistics($giftWell);
        $contributions = $giftWell->contributions()
            ->where('status', 'completed')
            ->latest()
            ->paginate(20);

        return view('couples.gift-well.show', compact('giftWell', 'statistics', 'contributions'));
    }

    public function withdraw(GiftWell $giftWell): RedirectResponse
    {
        $this->authorize('update', $giftWell);

        if ($giftWell->wedding_date->isFuture()) {
            return back()->withErrors('Cannot withdraw funds before wedding date.');
        }

        $result = $this->giftWellService->processWithdrawal($giftWell);

        if ($result['success']) {
            return back()->with('success', "Withdrawal processed! R{$result['withdrawal_amount']} will be transferred to your account.");
        }

        return back()->withErrors($result['error']);
    }
}