<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty($request->get('basic_token')) && $request->get('basic_token') == env('BASIC_AUTH')) {
            return $next($request);
        }

        return redirect()->route('unauthorized');
    }
}