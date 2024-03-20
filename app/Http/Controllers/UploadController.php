<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Upload;
use App\Models\Album;
use App\Models\UploadGenre;
use App\Jobs\UploadJob;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uploads = Upload::with(['uploadType', 'user', 'album'])->get();
        ;
        return response()->json(['uploads' => $uploads], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:100',
                'content' => 'required|file', //max is 25 mb
                'upload_type' => 'required|integer|exists:upload_types,id',
                'user_id' => 'required|integer|exists:users,id',
                'album_id' => 'required|integer|exists:albums,id',
                'duration' => 'required|',
                'visibility' => 'required|integer|exists:visibility_types,id',
                'genres' => 'required|array',
                'genres.*.value' => 'required|integer|exists:genres,id',
            ]);

            $contentPath = $request->file('content')->store('uploads/content');

            $thumbnailPath = null;
            if ($request->file('thumbnail') != null) {
                $thumbnailPath = $request->file('thumbnail')->store('uploads/cover');
            }

            $upload = Upload::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'content' => $contentPath,
                'thumbnail' => $thumbnailPath,
                'upload_type' => $request->input('upload_type'),
                'user_id' => $request->input('user_id'),
                'album_id' => $request->input('album_id'),
                'duration' =>$request->input('duration'),
                'visibility' =>$request->input('visibility'),
            ]);

            $genreData = [];
            foreach ($request->input('genres') as $genre) {
                $genreData[] = [
                    'upload_id' => $upload->id,
                    'genre_id' => $genre['value'],
                ];
            }
            DB::table('upload_genre')->insert($genreData);

            return response()->json(['message' => 'Successfully Uploaded!']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function showCover($filename)
    {
        $path = storage_path('app/uploads/cover/' . $filename);
        if (File::exists($path)) {
            return response()->file($path);
        }
        abort(404);
    }

    public function showContent($filename)
    {
        $path = storage_path('app/uploads/content/' . $filename);
        if (File::exists($path)) {
            return response()->file($path);
        }
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
