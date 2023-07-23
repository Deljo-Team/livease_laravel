<?php 

namespace App\Interfaces;

interface FileStorageInterface
{
    public function saveFile($files,$path,$name = "");
    public function getFileUrl($path);
    public function getFile($path);
    public function deleteFile($path);
}

?>