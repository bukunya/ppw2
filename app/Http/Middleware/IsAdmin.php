<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // If not authenticated, redirect to login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Normalize role and accept an is_admin flag as well
        $role = data_get($user, 'role');
        $isAdminFlag = data_get($user, 'is_admin') ?? $user->isAdmin();

        if ($isAdminFlag || ($role && Str::lower($role) === 'admin')) {
            return $next($request);
        }

        // Authenticated but not admin => 403 Forbidden
        abort(403);
    }
}
