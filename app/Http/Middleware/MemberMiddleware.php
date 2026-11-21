<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && (Auth::user()->group_id === 3 || Auth::user()->group_id === 4 || Auth::user()->group_id === 5 || Auth::user()->group_id === 6 || Auth::user()->group_id === 7|| Auth::user()->group_id === 1)) {
            return $next($request);
        }
        return abort(403, 'Unauthorized action.');
    }
}
