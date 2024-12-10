<?php

// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check()) {
            if (Auth::user()->role != $role) {
                // Jika user tidak sesuai dengan role yang diminta, alihkan
                return redirect('/');
            }
        }
        return $next($request);
    }
}
