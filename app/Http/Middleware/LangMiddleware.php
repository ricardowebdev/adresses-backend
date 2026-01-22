<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LangMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

        !empty($request->header('lang'))
            ? App::setLocale($request->header('lang'))
            : App::setLocale('pt_br');

        $response = $next($request);
        return $response;
    }
}
