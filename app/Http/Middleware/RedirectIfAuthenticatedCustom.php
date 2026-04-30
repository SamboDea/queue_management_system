<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedCustom
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}