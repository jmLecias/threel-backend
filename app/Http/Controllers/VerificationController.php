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
    protected $redirectUrl;

    // Constructor to initialize $redirectUrl
    public function __construct()
    {
        $this->redirectUrl = env('VERIFICATION_REDIRECT');
    }

    /**
     * Verify email from url.
     *
     */
    public function verify(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            if($user->email_verified_at != null) {

                // return response()->json(['status' => 'Successfully logged out']);
                return redirect($this->redirectUrl . 'already_verified');
            } else {
                $user->email_verified_at = now();
                $user->save();
                // should response JSONResponse
                return redirect($this->redirectUrl . 'verification_success');
            }
        } catch (Exception $e) {
            return redirect($this->redirectUrl . 'verification_error');
        }
    }
    /**
     * Send verification email.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        try {
            $user = User::findOrFail($request->input('id'));

            if($user->email_verified_at != null) {
                return redirect($this->redirectUrl)->with('status', 'already_verified');
            } else {
                $user->sendVerificationEmail();
                // should response JSONResponse
                return redirect($this->redirectUrl)->with('status', 'verification_sent');
            }
        } catch (Exception $e) {
            return redirect($this->redirectUrl)->with('status', 'verification_error');
        }
    }
}
