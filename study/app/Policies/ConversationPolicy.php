<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Conversation;
class ConversationPolicy
{
    /**
     * Create a new policy instance.
     */
    // app/Policies/ConversationPolicy.php
    public function view(User $user, Conversation $conversation): bool
    {
        return $conversation->users()
            ->where('users.id', $user->id)
            ->exists();
    }
}
