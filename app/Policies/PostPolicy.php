<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any posts.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view-posts');
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  User  $user
     * @param  Post $post
     * @return mixed
     */
    public function view(User $user, Post $post)
    {
        return $user->hasPermissionTo('view-posts');
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('manage-posts');
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param User $user
     * @param  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return $user->hasPermissionTo('manage-posts');
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  User $user
     * @param  Post $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return $user->hasPermissionTo('manage-posts');
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  User $user
     * @param  Post $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        return $user->hasPermissionTo('manage-posts');
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param User  $user
     * @param Post $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post)
    {
        return $user->hasPermissionTo('manage-posts');
    }
}
