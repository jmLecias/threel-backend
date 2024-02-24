<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class VerificationController extends Controller
{
    /**
     * Verify email from url.
     *
     */
    public function verify(Request $request, $id)
    {
        $redirectUrl = env('VERIFICATION_SUCCESS_URL');

        try {
            $user = User::findOrFail($id);

            if($user->email_verified_at != null) {
                return redirect($redirectUrl)->with('status', 'Email already verified!');
            } else {
                $user->email_verified_at = now();
                $user->save();
                // should response JSONResponse
                return redirect($redirectUrl)->with('status', 'Your email has been verified!');
            }
        } catch (Exception $e) {
            return redirect($redirectUrl)->with('status', 'Email verification error!');
        }
    }
    /**
     * Send verification email.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        $redirectUrl = env('VERIFICATION_SUCCESS_URL');

        try {
            $user = User::findOrFail($request->input('id'));

            if($user->email_verified_at != null) {
                return redirect($redirectUrl)->with('status', 'Email already verified!');
            } else {
                $user->sendVerificationEmail();
                // should response JSONResponse
                return redirect($redirectUrl)->with('status', 'Please check your email for verification.');
            }
        } catch (Exception $e) {
            return redirect($redirectUrl)->with('status', 'Error in sending verification email!');
        }
    }
}
