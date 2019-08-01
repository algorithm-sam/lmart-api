<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = 'user')
    {
        // check if the user has the required permission level;
        // It's either you check if he is authenticated in here and leave out the authentication middleware or you just check his permission level here and leave the authentication for the auth middleware
        if (Auth::check() && in_array($role, Auth::user()->roles()->pluck('name')->toArray())) {
            return $next($request);
        }
        return response()->json(['status' => 'error', 'message' => 'You are not authorized to visit this page contact your superior officers'], 401);
    }
}
