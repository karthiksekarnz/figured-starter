<?php

namespace App\Repositories\User;

use Rinvex\Repository\Contracts\RepositoryContract;

interface UserRepositoryContract extends RepositoryContract
{
    public function current();
}
