<?php
namespace App\Policies;

use App\Models\User;
use App\Models\BudgetCategory;

class BudgetCategoryPolicy
{
    public function update(User $user, BudgetCategory $category): bool
    {
        return $user->id === $category->coupleProfile->user_id;
    }
}