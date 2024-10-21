<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthorizeMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Implementasikan logika otorisasi Anda di sini
        // Contoh sederhana:
        if (!auth()->check() || auth()->user()->level->level_nama !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}