<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CorporateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && (Auth::user()->group_id === 6 || Auth::user()->group_id === 7 || Auth::user()->group_id === 1)) {
            // If the user is authenticated but not an admin, redirect or abort
            return $next($request);
        }
        return abort(403, 'Unauthorized action.');
    }
}
