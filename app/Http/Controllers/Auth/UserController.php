<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Auth\AuthServiceContract;

class UserController extends Controller
{
    /**
     * @var AuthServiceContract
     */
    private $authService;

    /**
     * @var ResponseFactory
     */
    protected $response;

    /**
     * UserController constructor.
     *
     * @param ResponseFactory $response
     * @param AuthServiceContract $authService
     */
    public function __construct(ResponseFactory $response, AuthServiceContract $authService)
    {
        $this->response = $response;
        $this->authService = $authService;

        parent::__construct($response);
    }

    /**
     * Return the current user.
     *
     * @return mixed
     */
    public function current()
    {
        try {
            return $this->response->json([
                'user' => $this->authService->currentUser()
            ]);
        } catch (\Exception $e) {
            return $this->response->json([
                'error' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
