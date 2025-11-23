<?php
namespace App\Http\Middleware;

use Closure;

class UserAuth
{
    public function handle($request, Closure $next)
    {
        if (!session('user_id')) {
            return redirect()->route('user.login')->withErrors(['auth' => 'Please login first']);
        }
        return $next($request);

        if (session('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        if (!session('user_id') || session('admin_id')) {
            return redirect()->route('user.login');
        }
    }
}
