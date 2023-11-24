<?php

namespace Database\Factories\Traits;

use Illuminate\Support\Facades\Storage;

trait HasFile
{
    public function getStorageImagesPath(): string
    {
        $storageFolder = storage_path('app/public/images/products');

        if (!Storage::exists('images/products')) {
            Storage::makeDirectory('images/products');
        }

        return $storageFolder;
    }
}
