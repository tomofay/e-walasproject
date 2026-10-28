<?php

namespace App\Http\Concerns;

trait ConvertsImagesToBase64
{
    protected function convertToBase64(string|array|null $path): ?string
    {
        if (is_array($path)) {
            $path = $path[0] ?? null;
        }

        if (! $path) {
            return null;
        }

        $fullPath = storage_path('app/public/' . $path);

        if (! file_exists($fullPath)) {
            return null;
        }

        $imageData = file_get_contents($fullPath);
        $mimeType = mime_content_type($fullPath);

        return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
    }
}
