<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\UserType;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user_type = auth()->user()->userType->user_type;
        $admin_user_type = UserType::find(3)->user_type; // id: 3 = admin

        if (auth()->check() && $user_type == $admin_user_type) {
            return $next($request);
        }

        return response()->json(['error' => 'Must be an admin.'], 401);
    }
}
