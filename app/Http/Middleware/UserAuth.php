<?php
namespace App\Http\Middleware;

use Closure;

class UserAuth
{
    public function handle($request, Closure $next)
    {
        if (!session('user_id') && !session('admin_id')) {
            return redirect()->route('user.login')->withErrors(['auth' => 'Please login first']);
        }
        
        if (session('admin_id')) {
            return redirect()->route('admin.dashboard') ->withErrors(['auth' => 'You are not a user']);
        }
        return $next($request);
    }
}
