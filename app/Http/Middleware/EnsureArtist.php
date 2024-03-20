<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\UserType;

class EnsureArtist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $user_type_id = auth()->user()->user_type;
        $artist_user_type_id = UserType::find(2)->id; // id: 2 = artist

        if (auth()->check() && $user_type_id >= $artist_user_type_id) {
            return $next($request);
        }

        return response()->json(['error' => 'Must be an artist.'],  401);
    }
}