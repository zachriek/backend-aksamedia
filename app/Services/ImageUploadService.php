<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
  protected $disk;
  protected $directory;

  public function __construct()
  {
    $this->disk = 'public';
    $this->directory = 'employees';
  }

  public function uploadImage($file, $oldImagePath = null): ?string
  {
    try {
      if (!$this->validateImage($file)) {
        throw new \Exception('Invalid image file.');
      }

      if ($oldImagePath) {
        $this->deleteImage($oldImagePath);
      }

      $disk = Storage::disk($this->disk);
      $filename = $this->generateUniqueFilename($file);
      $path = $this->directory . '/' . $filename;

      $disk->putFileAs($this->directory, $file, $filename);

      return $disk->url($path);
    } catch (\Exception $e) {
      throw new \Exception('Failed to upload image: ' . $e->getMessage());
    }
  }


  public function deleteImage(string $imagePath): bool
  {
    try {
      $relativePath = $this->extractRelativePathFromUrl($imagePath);

      if ($relativePath && Storage::disk($this->disk)->exists($relativePath)) {
        return Storage::disk($this->disk)->delete($relativePath);
      }

      return true;
    } catch (\Exception $e) {
      Log::error('Failed to delete image: ' . $e->getMessage());
      return false;
    }
  }

  private function generateUniqueFilename($file): string
  {
    $timestamp = now()->format('Y-m-d-H-i-s');
    $randomString = Str::random(8);
    $extension = strtolower($file->getClientOriginalExtension());

    return "employee-{$timestamp}-{$randomString}.{$extension}";
  }

  private function extractRelativePathFromUrl(string $url): ?string
  {
    $baseUrl = Storage::disk($this->disk)->url('');

    if (str_starts_with($url, $baseUrl)) {
      return substr($url, strlen($baseUrl));
    }

    return null;
  }

  public function validateImage($file): bool
  {
    $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    $maxSize = 2 * 1024 * 1024;

    return in_array($file->getMimeType(), $allowedMimes) &&
      $file->getSize() <= $maxSize;
  }
}
