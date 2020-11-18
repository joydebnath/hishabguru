<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Services\File\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    protected $uploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->uploadService = $imageUploadService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'imageable_type' => 'required',
            'imageable_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $image = $request->file('image');
        $name = time() . 'business_' . $request->imageable_id . '_logo.' . $image->getClientOriginalExtension();
        $path = $this->uploadService->uploadOne($image, '/', 's3', $name);

        $imageable = Image::firstWhere(function ($query) use ($request) {
            $query
                ->where('imageable_type', $request->imageable_type)
                ->where('imageable_id', $request->imageable_id);
        });

        if (collect($imageable)->isNotEmpty()) {
            Storage::disk('s3')->delete(basename($imageable->source));
            $imageable->update(['source' => Storage::disk('s3')->url($path)]);
        } else {
            $imageable = Image::create([
                'imageable_type' => $request->imageable_type,
                'imageable_id' => $request->imageable_id,
                'source' => Storage::disk('s3')->url($path)
            ]);
        }

        return response(['logo' => collect($imageable->fresh())->get('source', '')]);
    }
}
