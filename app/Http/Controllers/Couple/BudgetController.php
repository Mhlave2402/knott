<?php
namespace App\Http\Controllers\Couple;

use App\Http\Controllers\Controller;
use App\Models\BudgetCategory;
use App\Models\BudgetExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BudgetController extends Controller
{
    public function index()
    {
        $profile = Auth::user()->coupleProfile;
        
        if (!$profile) {
            return redirect()->route('couple.profile.create');
        }

        $categories = $profile->budgetCategories()->with('expenses')->get();
        
        $stats = [
            'total_allocated' => $categories->sum('allocated_amount'),
            'total_spent' => $categories->sum('spent_amount'),
            'remaining_budget' => $profile->total_budget - $categories->sum('spent_amount'),
            'categories_over_budget' => $categories->where('is_over_budget', true)->count(),
        ];

        return view('couple.budget.index', compact('profile', 'categories', 'stats'));
    }

    public function updateCategory(Request $request, BudgetCategory $category)
    {
        $this->authorize('update', $category);
        
        $validated = $request->validate([
            'allocated_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $category->update($validated);

        return redirect()->route('couple.budget.index')
                        ->with('success', 'Budget category updated successfully!');
    }

    public function addExpense(Request $request)
    {
        $profile = Auth::user()->coupleProfile;
        
        $validated = $request->validate([
            'budget_category_id' => 'required|exists:budget_categories,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date|before_or_equal:today',
            'vendor_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
            'receipt' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        // Verify category belongs to this couple
        $category = BudgetCategory::findOrFail($validated['budget_category_id']);
        if ($category->couple_profile_id !== $profile->id) {
            abort(403);
        }

        if ($request->hasFile('receipt')) {
            $validated['receipt_path'] = $request->file('receipt')
                ->store('budget-receipts/' . $profile->id, 'public');
        }

        BudgetExpense::create($validated);

        return redirect()->route('couple.budget.index')
                        ->with('success', 'Expense added successfully!');
    }

    public function deleteExpense(BudgetExpense $expense)
    {
        $this->authorize('delete', $expense);
        
        if ($expense->receipt_path) {
            Storage::disk('public')->delete($expense->receipt_path);
        }
        
        $expense->delete();

        return redirect()->route('couple.budget.index')
                        ->with('success', 'Expense deleted successfully!');
    }
}