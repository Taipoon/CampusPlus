<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ImageService
{
  public static function commentImageUpload($imageFile, $folderName)
  {
    if (is_array($imageFile)) {
      $file = $imageFile['image'];
    } else {
      $file = $imageFile;
    }
    $filename = uniqid(rand() . '_');
    $extension = $file->extension();

    $resized_image = InterventionImage::make($file)->resize(1920, 1080)->encode();

    // public/<folderName>/<fileNameToStore>.<extension> で保存
    $file_name_to_store = $filename . '.' . $extension;

    Storage::put('public/' . $folderName . '/' . $file_name_to_store, $resized_image);

    return $file_name_to_store;
  }

  public static function profileImageUpload($imageFile, $folderName = 'students/profiles')
  {
    $filename = uniqid(rand() . '_');
    $extension = $imageFile->extension();

    $resized_image = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();
    // public/<folderName>/<fileNameToStore>.<extension> で保存
    $file_name_to_store = $filename . '.' . $extension;
    Storage::put('public/' . $folderName . '/' . $file_name_to_store, $resized_image);

    return $file_name_to_store;
  }

  public static function iconImageUpload($imageFile, $folderName = 'students/icons')
  {
    $filename = uniqid(rand() . '_');
    $extension = $imageFile->extension();

    $resized_image = InterventionImage::make($imageFile)->resize(1080, 1080)->encode();

    $file_name_to_store = $filename . '.' . $extension;
    Storage::put('public/' . $folderName . '/' . $file_name_to_store, $resized_image);

    return $file_name_to_store;
  }
}
