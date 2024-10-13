<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LevelCheck
{
    /**
     * Handle an incoming request.
     * 
     * $level  [1. admin | 2. kasir]
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$level): Response
    {
        if (auth()->user() && in_array(auth()->user()->level, $level)) {
            return $next($request);
        }

        return redirect()->route('dashboard');
    }
}
