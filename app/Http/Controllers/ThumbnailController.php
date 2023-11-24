<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ThumbnailController extends Controller
{
    public function __invoke(
        string $dir,
        string $method,
        string $size,
        string $file
    )
    {
        abort_if(
            !in_array($size, config('thumbnail.allowed_size', [])),
            403,
            'Size not allowed'
        );

        $storage = Storage::disk('images');

        $realPath = "$dir/$file";
        $newDirPath = "$dir/$method/$size";
        $resultPath = "$newDirPath/$file";

        if (!$storage->exists($newDirPath)) {
            $storage->makeDirectory($newDirPath);
        }

        if ($storage->exists($resultPath)) {
            $image = Image::make($storage->path($realPath));
        }

    }
}
