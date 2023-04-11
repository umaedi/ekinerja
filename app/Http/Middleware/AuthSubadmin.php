<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSubadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->guard('pegawai')->check() && auth()->guard('pegawai')->user()->role !== 3 && auth()->guard('pegawai')->user()->role !== 2) {
            abort(403);
        }
        return $next($request);
    }
}
