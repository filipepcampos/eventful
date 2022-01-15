<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use App\Policies\EventPolicy;

class CommentPolicy
{
    use HandlesAuthorization;

    private function isOwner(User $user, Comment $comment) {
        return $user->id == $comment->author_id;
    }

    public function create(User $user, Event $event)
    {
        return Auth::check() && !EventPolicy::isAdmin($user) && EventPolicy::isAttendee($user, $event);
    }

    public function delete(User $user, Comment $comment) {
        return EventPolicy::isHost($user, Event::find($comment->event_id)) || $this->isOwner($user, $comment);
    }
}