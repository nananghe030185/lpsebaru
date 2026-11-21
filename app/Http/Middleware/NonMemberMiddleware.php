<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NonMemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if( Auth::check() && (Auth::user()->group_id === 2 || Auth::user()->group_id === 3 || Auth::user()->group_id === 4 || Auth::user()->group_id === 5 || Auth::user()->group_id === 6 || Auth::user()->group_id === 1)) {
            return $next($request);
            // If the user is authenticated but not an admin, redirect or abort
        }
        return abort(404, 'Unauthorized action.');
    }
}
