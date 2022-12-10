<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Controllers\ApiController;
use App\Http\Resources\EmployeeResource;

class AuthController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['logout']]);
    }

    /**
     * Register User via given credentials.
     *
     * @param  \App\Http\Requests\Api\AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthRequest $request)
    {
        try {
            $user = User::create(array_merge(
                $request->validated(),
                ['password' => bcrypt($request->password)]
            ));
            return $this->successResponse(null, 'You successfully registered your new account... You can login now');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  \App\Http\Requests\Api\AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request)
    {
        try {
            $credentials = array_merge($request->only(['email', 'password']), ['status' => 1]);
            if (! $token = auth()->attempt($credentials)) {
                throw new Exception('Wrong email or password or your account has been deactivated.', 401);
            }
            return $this->successResponse($this->respondWithToken($token), 'User with Contact Information');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return $this->successResponse(null, 'You logged out successfully');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return array
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new EmployeeResource(auth()->user())
        ];
    }
}