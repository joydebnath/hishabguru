<?php

namespace App\Services\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageUploadService
{
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $file = $uploadedFile->storePubliclyAs($folder, $name, $disk);

        return $file;
    }
}
