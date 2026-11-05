<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReferalSystem
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('r')) {

            $username = $request->query('r');

            $upline = User::where('username', $username)->first();
            if ($upline) {
                session([
                    'upline_id' => $upline->id
                ]);
            }
        }
        return $next($request);
    }
}
