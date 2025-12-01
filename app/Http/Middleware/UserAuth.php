<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class UserAuth
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('user')->check() && !Auth::guard('admin')->check()) {
            return redirect()->route('user.login')
                ->withErrors(['auth' => 'Please login first']);
        }

        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard')
                ->withErrors(['auth' => 'You are not a user']);
        }

        return $next($request);
    }
}
