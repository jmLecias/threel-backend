<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Upload;
use App\Jobs\UploadJob;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uploads = Upload::with(['uploadType', 'user'])->get();
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
                'description' => 'required|string',
                'content' => 'required|file|mimes:mp3,ogg,aac', //max is 25 mb
                'thumbnail' => 'required|file|mimes:jpg,jpeg,png', //max is 5 mb
                'upload_type' => 'required|integer|exists:upload_types,id',
                'user_id' => 'required|integer|exists:users,id',
            ]);

            $contentPath = $request->file('content')->store('uploads/content');
            $thumbnailPath = $request->file('thumbnail')->store('uploads/thumbnails');

            $upload = Upload::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'content' => $contentPath,
                'thumbnail' => $thumbnailPath,
                'upload_type' => $request->input('upload_type'),
                'user_id' => $request->input('user_id'),
            ]);

            // UploadJob::dispatch($request);

            return response()->json(['message' => 'Upload is being processed..']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function showThumbnail($filename)
    {
        $path = storage_path('app/uploads/thumbnails/' . $filename);
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
