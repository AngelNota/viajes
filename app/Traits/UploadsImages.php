<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UploadsImages
{
    /**
     * Handle multiple image uploads and return JSON encoded paths.
     *
     * @param Request $request
     * @param string $inputName
     * @param string $folder
     * @return string|null
     */
    public function uploadMultipleImages(Request $request, string $inputName = 'imagen', string $folder = 'images'): ?string
    {
        if ($request->hasFile($inputName)) {
            $imagenes = [];
            foreach ($request->file($inputName) as $file) {
                $imagenes[] = $file->store($folder, 'public');
            }
            return json_encode($imagenes);
        }

        return null;
    }
}
