<?php
namespace App\Policies;

use App\Models\User;
use App\Models\BudgetExpense;

class BudgetExpensePolicy
{
    public function delete(User $user, BudgetExpense $expense): bool
    {
        return $user->id === $expense->budgetCategory->coupleProfile->user_id;
    }
}