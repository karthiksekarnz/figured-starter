<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\Auth\UserLoginRequest;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        AuthenticatesUsers::login as traitLogin;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * @var ResponseFactory
     */
    protected $response;

    /**
     * LoginController constructor.
     *
     * @param ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
        $this->middleware('guest')->except('logout');

        parent::__construct($response);
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $userToken = $user->createToken('User personal token');
            $userToken->token->expires_at = Carbon::now()->addSeconds(config('defaults.token-expiry-seconds'));
            $userToken->token->save();

            return $this->response->json([
                'user' => $user->load('roles'),
                'token' => [
                    'access_token' => $userToken->accessToken,
                    'type' => 'Bearer',
                    'expires_at' => Carbon::parse($userToken->token->expires_at)->toDateTimeString(),
                ]
            ]);
        }

        return $this->response->json([
            'errors' => [
                'These credentials do not match our records.'
            ]
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->response->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
