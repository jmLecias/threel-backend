<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
                'username' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8'
            ]);

            User::create([
                'name' => 'test name',
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
            ]);

            $credentials = $request->only('email', 'password');
            $token = auth()->attempt($credentials);

            return $this->respondWithToken($token);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json(['errors' => $errors], 422);
        }
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        $response = response()->json(['message' => 'Successfully logged out']);
        $response->withCookie(cookie('access_token', '', -1, null, null, false, true));

        return $response;
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $newToken = auth()->refresh();

        $minutes = auth()->factory()->getTTL();
        $response = response()->json([
            'token_type' => 'bearer',
            'expires_in' => $minutes * 60
        ]);
        $response->withCookie(cookie('access_token', $newToken, $minutes, null, null, false, true));

        return $response;
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $minutes = auth()->factory()->getTTL();
        $response = response()->json([
            'token_type' => 'bearer',
            'expires_in' => $minutes * 60
        ]);
        $response->withCookie(cookie('access_token', $token, $minutes, null, null, false, true));

        return $response;
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
}