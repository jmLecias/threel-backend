<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\Request;
use App\Models\Upload;

class UploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;

    /**
     * Create a new job instance.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $request = $this->request;

        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'content' => 'required|file|mimes:mp3,ogg,aac|max:25600', //max is 25 mb
            'thumbnail' => 'required|file|mimes:jpg,jpeg,png|max:5120', //max is 5 mb
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

        // Optionally, you can broadcast an event here to notify the frontend about the upload completion
    }
}
