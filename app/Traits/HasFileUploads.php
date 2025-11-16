<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait HasFileUploads
{
    /**
     * Upload and process an image file
     */
    public function uploadImage(UploadedFile $file, string $directory = 'uploads', bool $createThumbnail = true): array
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs($directory, $filename, 'public');
        
        $result = [
            'original' => $path,
            'url' => Storage::url($path),
        ];
        
        if ($createThumbnail && in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif'])) {
            $thumbnailPath = $directory . '/thumbnails/' . $filename;
            
            $image = Image::make($file);
            $image->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            Storage::put('public/' . $thumbnailPath, $image->encode());
            
            $result['thumbnail'] = $thumbnailPath;
            $result['thumbnail_url'] = Storage::url($thumbnailPath);
        }
        
        return $result;
    }
    
    /**
     * Upload multiple files
     */
    public function uploadMultiple(array $files, string $directory = 'uploads'): array
    {
        $uploaded = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $uploaded[] = $this->uploadImage($file, $directory);
            }
        }
        
        return $uploaded;
    }
    
    /**
     * Delete uploaded files
     */
    public function deleteFile(string $path): bool
    {
        return Storage::delete('public/' . $path);
    }
}
