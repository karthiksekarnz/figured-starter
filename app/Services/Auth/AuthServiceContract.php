<?php

namespace App\Services\Auth;

interface AuthServiceContract
{
    /**
     * @return mixed
     */
    public function currentUser();

    /**
     * @param array $data
     * @return mixed
     */
    public function register(array $data);
}
