<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserAuth
{
    public function handle($request, Closure $next)
    {
       
        if (Auth::guard('admin')->check()) {
            return redirect()
                ->route('admin.dashboard')
                ->withErrors(['auth' => 'Anda bukan user']);
        }

       
        if (!Auth::guard('user')->check()) {
            return redirect()
                ->route('user.login')
                ->withErrors(['auth' => 'Please login first']);
        }

        return $next($request);
    }
}
