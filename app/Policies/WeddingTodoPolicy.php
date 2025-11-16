<?php
namespace App\Policies;

use App\Models\User;
use App\Models\WeddingTodo;

class WeddingTodoPolicy
{
    public function update(User $user, WeddingTodo $todo): bool
    {
        return $user->id === $todo->coupleProfile->user_id;
    }

    public function delete(User $user, WeddingTodo $todo): bool
    {
        return $user->id === $todo->coupleProfile->user_id;
    }
}