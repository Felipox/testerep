<?php

namespace App\Policies;

use App\Domain\Posts\PostEntity;
use App\Domain\Posts\PostStatus;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostEntity $post): bool
    {
        if(($user->id === $post->author_id) && ($post->status!== PostStatus::ARCHIVED))
            {
                return true;
            }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostEntity $post): bool
    {
        if($user->id === $post->author_id)
            {
                return true;
            }
            return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
