<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserType;
use Carbon\Carbon;

class UserController extends Controller
{
    public function users()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }

    public function activateUser($id)
    {
        $user = User::findOrFail($id);

        // Only admins (id: 3) can access this controller
        // Admins can only deactivate user_types below them
        // Listeners (id: 1) and Artists (id: 2)
        // Admins can not deactivate neither other admins nor the superadmin
        if ($user->user_type < auth()->user()->user_type) {
            $user->status_type = 1; // id: 1 corresponds to 'active'
            $user->save();

            return response()->json(['users' => User::all()], 200);
        } else {
            return response()->json(['errors' => 'Admins can not deactivate user_type: '.$user->userType()], 409);
        }
    }

    public function deactivateUser($id)
    {
        $user = User::findOrFail($id);

        // Only admins (id: 3) can access this controller
        // Admins can only deactivate user_types below them
        // Listeners (id: 1) and Artists (id: 2)
        // Admins can not deactivate neither other admins nor the superadmin
        if ($user->user_type < auth()->user()->user_type) {
            $user->status_type = 3; // id: 3 corresponds to 'deactivated'
            $user->save();

            return response()->json(['users' => User::all()], 200);
        } else {
            return response()->json(['errors' => 'Admins can not activate user_type: '.$user->userType()], 409);
        }
    }

    public function updateUser($id)
    {
        $user = User::findOrFail($id);

        // Only admins (id: 3) can access this controller
        // Admins can only update user_types below them
        // Listeners (id: 1) and Artists (id: 2)
        // Admins can not update neither other admins nor the superadmin
        if ($user->user_type < auth()->user()->user_type) {
            

            return response()->json(['users' => User::all()], 200);
        } else {
            return response()->json(['errors' => 'Admins can not update user_type: '.$user->userType()], 409);
        }
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Only admins (id: 3) can access this controller
        // Admins can only delete user_types below them
        // Listeners (id: 1) and Artists (id: 2)
        // Admins can not delete neither other admins nor the superadmin
        if ($user->user_type < auth()->user()->user_type) {
            $user->delete(); 

            return response()->json(['users' => User::all()], 200);
        } else {
            return response()->json(['errors' => 'Admins can not delete user_type: '.$user->userType()], 409);
        }
    }

    public function verifyToArtist($id)
    {
        $listener = User::findOrFail($id);

        if ($listener->userType->user_type == UserType::find(1)->user_type) { // must be a listener
            $listener->artist_verified_at = Carbon::now()->toDateTimeString();
            $listener->status_type = 1; // id: 1 corresponds to 'active'
            $listener->save();

            // Add a function here to send Artist Verification Request granted email

            return response()->json(['users' => $listener], 200);
        } else {
            return response()->json(['errors' => 'User of type ('.$listener->userType().') can not be verified to artist!'], 409);
        }
    }
}
