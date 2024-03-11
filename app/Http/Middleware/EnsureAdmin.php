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
        $user_type_id = auth()->user()->user_type;
        $admin_user_type_id = UserType::find(3)->id; // id: 3 = admin

        if (auth()->check() && $user_type_id >= $admin_user_type_id) {
            return $next($request);
        }

        return response()->json(['error' => 'Must be an admin.'], 401);
    }
}
