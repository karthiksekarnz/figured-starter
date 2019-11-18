<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Services\Auth\AuthServiceContract;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * @var AuthServiceContract
     */
    private $authService;

    /**
     * @var ResponseFactory
     */
    protected $response;

    /**
     * RegisterController constructor.
     *
     * @param ResponseFactory $response
     * @param AuthServiceContract $authService
     */
    public function __construct(ResponseFactory $response, AuthServiceContract $authService )
    {
        $this->response = $response;
        $this->authService = $authService;

        $this->middleware('guest');

        parent::__construct($response);
    }

    /**
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request)
    {
        try {
            $result = $this->authService->register([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

            return $this->response->json($result);
        } catch (\Exception $e) {
            return $this->response->json([
                'error' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
