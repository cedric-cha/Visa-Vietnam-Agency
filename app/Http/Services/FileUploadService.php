<?php

namespace App\Http\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class FileUploadService
{
    public function handle(UploadedFile $uploadedFile, &$filename): bool
    {
        $originalFilename = File::name($uploadedFile->getClientOriginalName());
        $filename = Str::slug($originalFilename, '_', 'fr').'_'.strtotime('now').'.'.$uploadedFile->getClientOriginalExtension();

        return $uploadedFile->move(storage_path('app/public/'), $filename)->isFile();
    }
}
