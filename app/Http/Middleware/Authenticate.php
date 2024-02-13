<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $accessToken = $this->getAccessTokenFromCookie($request);

        // if ($accessToken && !$this->validateAccessToken($accessToken)) {
        //     return route('login'); // Replace with your actual login route
        // }

        return $request->expectsJson() ? null : response()->json(['Unauthorized person']);;
    }


    protected function getAccessTokenFromCookie(Request $request): ?string
    {
        $cookie = $request->cookie('access_token', null);
        $response = response()->json([$cookie], 401);
        return $response;
    }

    protected function validateAccessToken($token): bool
{
    try {
        // Attempt to decode the token. This will throw an exception if the token is invalid.
        $decodedToken = JWTAuth::setToken($token)->getPayload();

        // Check if the token has expired
        if ($decodedToken->get('exp') <= time()) {
            return false;
        }

        // Optionally, perform any additional checks you need, such as checking the user ID against your database.
        // ...

        return true;
    } catch (JWTException $e) {
        // Handle the case where the token is not valid.
        return false;
    }
}
}
