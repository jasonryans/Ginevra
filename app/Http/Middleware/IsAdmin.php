<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->is_admin) {
            abort(403, 'Mohon maaf, akses ke halaman ini hanya diperbolehkan untuk Admin.');
        }

        return $next($request);
    }
}