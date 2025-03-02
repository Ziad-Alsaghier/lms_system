<?php

namespace App\services;

trait Image
{
    // This Function For Upload Image
    
    public function uploadImage($image, $path)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs($path, $imageName, 'public');
        return $path  . $imageName;
    }

    // This Function For Delete Image
    public function deleteImage($path)
    {
        if (file_exists('storage/' . $path)) {
            unlink('storage/' . $path);
        }
    }

    // This Function For Update Image
    public function updateImage($image, $oldImage, $path)
    {
        $this->deleteImage($oldImage);
        return $this->uploadImage($image, $path);
    }
    
}
