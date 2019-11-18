<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Rinvex\Repository\Repositories\EloquentRepository;

class UserRepository extends EloquentRepository implements UserRepositoryContract
{
    protected $model = User::class;

    public function current()
    {
        if (Auth::check()) {
            $user = $this->find(Auth::id());

            if (!$user) {
                return null;
            }

            return $this->with('roles')->find($user->id);
        }

        return null;
    }
}
