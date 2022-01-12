<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use App\Policies\EventPolicy;

class CommentPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Event $event)
    {
        return Auth::check() && !EventPolicy::isAdmin($user) && EventPolicy::isAttendee($user, $event);
    }
}