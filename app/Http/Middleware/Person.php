<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class Person extends ApiController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  ...$guards
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if(! in_array(auth()->user()->type, $guards)) {
            return $this->errorResponse('You don\'t have permission to access this route.', 403);
        }
        
        return $next($request);
    }
}
