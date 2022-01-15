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

    public function deleteComment(User $user, Comment $comment) {
        return EventPolicy::isHost($user, Event::find($comment->event_id)) || $this->isOwner($user, $comment);
    }

    public function addRatingComment(User $user, Comment $comment) {
        return !($this->isOwner($user, $comment));
    }
}