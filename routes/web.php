<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Couple\DashboardController as CoupleDashboardController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Guest\DashboardController as GuestDashboardController;
use App\Http\Controllers\Couple\GiftWellController;
use App\Http\Controllers\Guest\ContributionController;
use App\Http\Controllers\Vendor\SubscriptionController;
use App\Http\Controllers\Api\PaymentController;

// ==========================
// Public Routes
// ==========================
Route::get('/', function () {
    return view('public.home');
});

// Vendor Listings moved to couple routes group

require __DIR__.'/auth.php';

// ==========================
// Admin Routes
// ==========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

// ==========================
// Couple Routes
// ==========================
Route::middleware(['auth', 'role:couple'])->prefix('couple')->name('couple.')->group(function () {
    // Vendor Directory
    Route::get('/vendors', [App\Http\Controllers\Couple\VendorDirectoryController::class, 'index'])
        ->name('vendors.index');
    Route::middleware(['auth', 'role:couple'])->group(function () {
    Route::get('/quotes/wizard', [App\Http\Controllers\Couple\QuoteWizardController::class, 'index']);
    Route::post('/quotes/send', [App\Http\Controllers\Couple\QuoteWizardController::class, 'sendRequests']);
});

    // Dashboard
    Route::get('/dashboard', [CoupleDashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile/create', [App\Http\Controllers\Couple\ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [App\Http\Controllers\Couple\ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [App\Http\Controllers\Couple\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Couple\ProfileController::class, 'update'])->name('profile.update');

    // Budget Management
    Route::get('/budget', [App\Http\Controllers\Couple\BudgetController::class, 'index'])->name('budget.index');
    Route::put('/budget/category/{category}', [App\Http\Controllers\Couple\BudgetController::class, 'updateCategory'])->name('budget.category.update');
    Route::post('/budget/expense', [App\Http\Controllers\Couple\BudgetController::class, 'addExpense'])->name('budget.expense.store');
    Route::delete('/budget/expense/{expense}', [App\Http\Controllers\Couple\BudgetController::class, 'deleteExpense'])->name('budget.expense.destroy');

    // Guests
    Route::get('/guests', [App\Http\Controllers\Couple\GuestController::class, 'index'])->name('guests.index');
    Route::get('/guests/create', [App\Http\Controllers\Couple\GuestController::class, 'create'])->name('guests.create');
    Route::post('/guests', [App\Http\Controllers\Couple\GuestController::class, 'store'])->name('guests.store');
    Route::get('/guests/{guest}/edit', [App\Http\Controllers\Couple\GuestController::class, 'edit'])->name('guests.edit');
    Route::put('/guests/{guest}', [App\Http\Controllers\Couple\GuestController::class, 'update'])->name('guests.update');
    Route::delete('/guests/{guest}', [App\Http\Controllers\Couple\GuestController::class, 'destroy'])->name('guests.destroy');
    Route::post('/guests/import', [App\Http\Controllers\Couple\GuestController::class, 'bulkImport'])->name('guests.import');

    // To-do List
    Route::get('/todos', [App\Http\Controllers\Couple\TodoController::class, 'index'])->name('todos.index');
    Route::post('/todos', [App\Http\Controllers\Couple\TodoController::class, 'store'])->name('todos.store');
    Route::patch('/todos/{todo}/toggle', [App\Http\Controllers\Couple\TodoController::class, 'toggle'])->name('todos.toggle');
    Route::delete('/todos/{todo}', [App\Http\Controllers\Couple\TodoController::class, 'destroy'])->name('todos.destroy');
    Route::post('/todos/suggestions', [App\Http\Controllers\Couple\TodoController::class, 'suggestions'])->name('todos.suggestions');

    // Couple Quote Routes
    Route::resource('quotes', App\Http\Controllers\Couple\QuoteRequestController::class)
        ->except(['edit', 'update', 'destroy']);
    Route::post('quotes/{quote_request}/retry', [App\Http\Controllers\Couple\QuoteRequestController::class, 'retryMatching'])
        ->name('quotes.retry');
    Route::get('quotes/{quote_request}/compare', [App\Http\Controllers\Couple\QuoteRequestController::class, 'compare'])
        ->name('quotes.compare');
    Route::post('quotes/{quote_request}/responses/{quote_response}/accept', [App\Http\Controllers\Couple\QuoteRequestController::class, 'acceptQuote'])
        ->name('quotes.accept');
    Route::post('quotes/{quote_request}/responses/{quote_response}/reject', [App\Http\Controllers\Couple\QuoteRequestController::class, 'rejectQuote'])
        ->name('quotes.reject');
    Route::post('quotes/{quote_request}/responses/{quote_response}/request-info', [App\Http\Controllers\Couple\QuoteRequestController::class, 'requestInfo'])
        ->name('quotes.request-info');
    Route::get('/compare-quotes', [App\Http\Controllers\Couple\QuoteRequestController::class, 'compareQuotes'])->name('compare-quotes');
});

// ==========================
// Vendor Routes
// ==========================
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile/create', [App\Http\Controllers\Vendor\ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [App\Http\Controllers\Vendor\ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [App\Http\Controllers\Vendor\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Vendor\ProfileController::class, 'update'])->name('profile.update');

    // Services
    Route::get('/services', [App\Http\Controllers\Vendor\ServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [App\Http\Controllers\Vendor\ServiceController::class, 'store'])->name('services.store');
    Route::delete('/services/{service}', [App\Http\Controllers\Vendor\ServiceController::class, 'destroy'])->name('services.destroy');

    // Portfolio
    Route::get('/portfolio', [App\Http\Controllers\Vendor\PortfolioController::class, 'index'])->name('portfolio.index');
    Route::post('/portfolio', [App\Http\Controllers\Vendor\PortfolioController::class, 'store'])->name('portfolio.store');
    Route::delete('/portfolio/{item}', [App\Http\Controllers\Vendor\PortfolioController::class, 'destroy'])->name('portfolio.destroy');

    // Vendor Quote Response Routes
    Route::get('quotes', [App\Http\Controllers\Vendor\QuoteResponseController::class, 'index'])
        ->name('quotes.index');
    Route::get('quotes/{quote_response}', [App\Http\Controllers\Vendor\QuoteResponseController::class, 'show'])
        ->name('quotes.show');
    Route::get('quotes/{quote_response}/respond', [App\Http\Controllers\Vendor\QuoteResponseController::class, 'respond'])
        ->name('quotes.respond');
    Route::post('quotes/{quote_response}/submit', [App\Http\Controllers\Vendor\QuoteResponseController::class, 'submitResponse'])
        ->name('quotes.submit');
    Route::post('quotes/{quote_response}/decline', [App\Http\Controllers\Vendor\QuoteResponseController::class, 'decline'])
        ->name('quotes.decline');
    Route::post('quotes/{quote_response}/message', [App\Http\Controllers\Vendor\QuoteResponseController::class, 'sendMessage'])
        ->name('quotes.message');
});

// ==========================
// Guest Routes
// ==========================
Route::middleware(['auth', 'role:guest'])->prefix('guest')->name('guest.')->group(function () {
    Route::get('/dashboard', [GuestDashboardController::class, 'index'])->name('dashboard');
});

// Couple Routes (Gift Well Management)
Route::middleware(['auth', 'role:couple'])->prefix('couples')->name('couples.')->group(function () {
    // Gift Well CRUD
    Route::get('/gift-well', [GiftWellController::class, 'index'])->name('gift-well.index');
    Route::get('/gift-well/create', [GiftWellController::class, 'create'])->name('gift-well.create');
    Route::post('/gift-well', [GiftWellController::class, 'store'])->name('gift-well.store');
    Route::get('/gift-well/{giftWell}', [GiftWellController::class, 'show'])->name('gift-well.show');
    Route::get('/gift-well/{giftWell}/edit', [GiftWellController::class, 'edit'])->name('gift-well.edit');
    Route::put('/gift-well/{giftWell}', [GiftWellController::class, 'update'])->name('gift-well.update');
    Route::delete('/gift-well/{giftWell}', [GiftWellController::class, 'destroy'])->name('gift-well.destroy');
    
    // Gift Well Management
    Route::get('/gift-well/{giftWell}/manage', [GiftWellController::class, 'manage'])->name('gift-well.manage');
    Route::get('/gift-well/{giftWell}/contributions', [GiftWellController::class, 'contributions'])->name('gift-well.contributions');
    Route::post('/gift-well/{giftWell}/withdraw', [GiftWellController::class, 'withdraw'])->name('gift-well.withdraw');
});

// Vendor Routes (Subscription Management)
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/subscription/plans', [SubscriptionController::class, 'plans'])->name('subscription.plans');
    Route::post('/subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
    Route::get('/subscription/billing', [SubscriptionController::class, 'billing'])->name('subscription.billing');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
});

// Public Guest Routes (Gift Well Contributions)
Route::prefix('gift-well')->name('guests.gift-well.')->group(function () {
    Route::get('/{giftWell}', [ContributionController::class, 'show'])->name('show');
    Route::post('/{giftWell}/contribute', [ContributionController::class, 'contribute'])->name('contribute');
    Route::get('/contribution/{contribution}/receipt', [ContributionController::class, 'receipt'])->name('receipt');
});

// API Routes for Payments
Route::prefix('api')->name('api.')->group(function () {
    Route::post('/payment/vendor-subscription', [PaymentController::class, 'processVendorSubscription'])->name('payment.vendor-subscription');
    Route::post('/payment/booking-deposit', [PaymentController::class, 'processBookingDeposit'])->name('payment.booking-deposit');
    Route::post('/payment/gift-well-contribution', [PaymentController::class, 'processGiftWellContribution'])->name('payment.gift-well-contribution');
    Route::post('/webhooks/stripe', [PaymentController::class, 'handleWebhook'])->name('webhooks.stripe');
});
