<?php
namespace App\Http\Middleware;

use Closure;

class AdminAuth
{
    public function handle($request, Closure $next)
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login')->withErrors(['auth' => 'Admin access required']);
        }
        

        if (session('user_id')) {
            return redirect()->route('user.dashboard')->withErrors(['auth' => 'You are not admin']);
        }
        return $next($request);
    }

    
}
