<?php

namespace app\helpers;

use yii\web\UploadedFile;

class Storage
{
    public static function saveUploadedFile(UploadedFile $uploadedFile, string $filePath): bool
    {
        return $uploadedFile->saveAs(self::getStoragePath() . $filePath);
    }

    public static function delete(string $filePath): bool
    {
        $fullPath = self::getStoragePath() . $filePath;
        if (!file_exists($fullPath)) {
            return false;
        }

        return unlink($fullPath);
    }

    private static function getStoragePath(): string
    {
        return \Yii::getAlias('@webroot') . '/storage/';
    }
}
