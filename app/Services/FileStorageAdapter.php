<?php

namespace App\Services;

use App\Interfaces\FileStorageInterface;
use Illuminate\Support\Facades\Storage;

class FileStorageAdapter implements FileStorageInterface
{
   function saveFile($file, $path, $name = "")
   {
    //  save the files to the storage
   {
     if ($name == "") {
     $name = $file->getClientOriginalName();
     }
     return $file->storeAs($path, $name, 'public');
     
     }
   

   }
   function getFile($path)
   {
        return Storage::disk('public')->get($path);
   }
   function deleteFile($path)
   {
        return Storage::disk('public')->delete($path);
   }

    function getFileUrl($path)
    {
          return Storage::url($path);
    }
}
