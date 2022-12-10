<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Return Custom JSON Response when user is authenticated.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    protected function unauthenticated()
    {
        abort(response()->json([
            'status' => 'Error',
            'message' => 'Unauthenticated'
        ], 401));
    }
}
