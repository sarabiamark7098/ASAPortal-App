<?php
use \Illuminate\Http\UploadedFile;
use \Illuminate\Support\Str;
use \Illuminate\Support\Facades\Storage;

if (!function_exists('upload_file')) {
    /**
     * Example custom helper
     */
    function upload_file(UploadedFile $uploadedFile, string $folder)
    {
        $disk = config('filesystems.default', 'local');

        $extension = $uploadedFile->getClientOriginalExtension() ?? 'bin';
        $datePart = now()->format('Ymd-His');
        $randomPart = Str::random(6);

        $filename = "{$datePart}-{$randomPart}.{$extension}";
        $subfolder = now()->format('Y-m-d');

        $path = "{$folder}/{$subfolder}/{$filename}";

        $success = Storage::disk($disk)
            ->put($path, file_get_contents($uploadedFile->getRealPath()));

        if (!$success) {
            throw new \Exception("Failed uploading file.");
        }

        return [
            'filename' => $filename,
            'path' => $path,
        ];
    }
}
