<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class AdminAuth
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check() && !Auth::guard('user')->check()) {
            return redirect()->route('admin.login')->withErrors(['auth' => 'Admin access required']);
        }

        if (Auth::guard('user')->check()) {
            return redirect()->route('user.dashboard')->withErrors(['auth' => 'You are not admin']);
        }
        return $next($request);
    }

    
}
