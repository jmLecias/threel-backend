<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class DataController extends Controller
{
    public function artistDisplay() {
        $artists = User::where('user_type', 'artist')->where('is_banned', false)->get();

        return response()->json(['artists' => $artists]);
    }

    public function banArtist($id) {
        $artist = User::find($id);
        if ($artist) {
            $artist->is_banned = true;
            $artist->save();
        } 
    }

    public function displayBannedArtist() {
        $banned_artists = User::where('user_type', 'artist')->where('is_banned', true)->get();

        return response()->json(['banned_artists' => $banned_artists]);
    }

    public function displayNotVerifiedArtist() {
        $nverified_artists = User::whereNull('artist_verified_at')->where('user_type', 'artist')->get();

        return response()->json(['nverified_artists' => $nverified_artists]);
    }

    public function restoreArtist($id) {
        $artist = User::find($id);
        if ($artist) {
            $artist->is_banned = false;
            $artist->save();
        } 
    }

    public function verifyArtist($id) {
        $artist = User::find($id);
        if ($artist) {
            $artist->artist_verified_at = now();
            $artist->save();
        } 
    }
}
