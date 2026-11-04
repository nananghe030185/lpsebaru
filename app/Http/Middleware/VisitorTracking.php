<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VisitorTracking
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response =  $next($request);
        try{
            $api = Http::timeout(3)->get('http://ip-api.com/json/{$request->ip()}');
            Visitor::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->url(),
                'referer' => $request->header('referer'),
                'method' => $request->method(),
                'country' => $api->json('country'),
            ]);
        } catch(\Throwable $e){
            report($e);
        }
        return $response;
    }
}
