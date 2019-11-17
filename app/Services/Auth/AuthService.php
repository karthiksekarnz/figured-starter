<?php

namespace App\Services\Auth;

use Carbon\Carbon;
use App\Repositories\User\UserRepositoryContract;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class AuthService implements AuthServiceContract
{
    /**
     * @var UserRepositoryContract
     */
    private $userRepository;

    /**
     * @var AuthFactory
     */
    private $authFactory;

    /**
     * AuthService constructor.
     *
     * @param UserRepositoryContract $userRepository
     * @param AuthFactory $authFactory
     */
    public function __construct(UserRepositoryContract $userRepository, AuthFactory $authFactory)
    {
        $this->userRepository = $userRepository;
        $this->authFactory = $authFactory;
    }

    /**
     * @return mixed
     */
    public function currentUser()
    {
        return $this->userRepository->current();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function register(array $data)
    {
        $user = $this->userRepository->store(null, $data);
        $user->assignRole('Reader');
        $token = $user->createToken('User personal token');

        $this->authFactory->login($user);

        return [
            'user' => $user->with('roles'),
            'token' => [
                'access_token' => $token->accessToken,
                'type' => 'Bearer',
                'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()
            ]
        ];
    }
}
