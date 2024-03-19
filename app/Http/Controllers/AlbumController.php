<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Album;

class AlbumController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
                'description' => 'required|string',
                'cover' => 'required|file',
            ]);

            $albumCoverPath = $request->file('cover')->store('uploads/album_covers');


            $album = Album::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'cover' => $albumCoverPath,
            ]);

            return response()->json(['album' => $album]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

}
