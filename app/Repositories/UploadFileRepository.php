<?php

namespace App\Repositories;

use App\Models\Shop;
use App\Models\Artist;
use App\Models\Exhibition;
use App\Models\OpenCall;
use App\Models\OpenCallResponse;

class UploadFileRepository
{

    /**
     * Generate File Name.
     *
     * @param string $module
     * @param object $file
     * @param string|int $extraParmeter
     * @return string
     */
    public function getFileName($module, $file, $extraParmeter = null) : string
    {
        $fileExtension = $file->extension();

        $fileName = match ($module) {
            'exhibition' => 'exhibition',
            'exhibition_cover' => 'exhibition_cover',
            'shop' => 'shop',
            'artist' => 'aritst',
            'artist_cover' => 'artist_cover',
            'opencall' => 'opencall',
            'front_opencall' => 'opencallform',
        };

        if ($extraParmeter && $module != 'front_opencall') {
            $fileName = $fileName.'_'. $extraParmeter;
        }

        $fileName = $fileName.'_'.rand(1000,9999);
        $fileName = $fileName.'_'.time();
        $fileName = str_replace('/', '_', $fileName.'.'.$fileExtension);

        return $fileName;
    }

    /**
     * Generate Upload Path.
     *
     * @param string $module
     * @param int|string $parentId
     * @return string
     */
    public function getUploadPath($module, $parentId = null)
    {
        return match ($module) {
            'exhibition' => ($parentId) ? public_path(Exhibition::UPLOAD_PATH.$parentId) : public_path(Exhibition::UPLOAD_PATH),
            'exhibition_cover' => public_path(Exhibition::UPLOAD_COVER_PATH),
            'shop' => ($parentId) ? public_path(Shop::UPLOAD_PATH.$parentId) : public_path(Shop::UPLOAD_PATH),
            'artist' => ($parentId) ? public_path(Artist::UPLOAD_PATH.$parentId) : public_path(Artist::UPLOAD_PATH),
            'artist_cover' => public_path(Artist::UPLOAD_COVER_PATH),
            'opencall' => ($parentId) ? public_path(OpenCall::UPLOAD_PATH.$parentId) : public_path(OpenCall::UPLOAD_PATH),
            'front_opencall' => ($parentId) ? public_path(OpenCallResponse::UPLOAD_ART_DATA_PATH.$parentId) : public_path(OpenCallResponse::UPLOAD_ART_DATA_PATH),
        };
    }

    public function uploadFile($module, $image, $parentId = null)
    {
        $imageName  = $this->getFileName($module, $image, $parentId);
        $uploadPath = $this->getUploadPath($module, $parentId);
        $image->move($uploadPath, $imageName);

        return $imageName;
    }

    public function removeFile($path, $fileName, $addSeparator = false): bool
    {
        $addSeparator = ($addSeparator) ? '/' : '';
        return unlink($path . $addSeparator . $fileName);
    }
}
