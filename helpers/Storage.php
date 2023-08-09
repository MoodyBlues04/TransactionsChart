<?php

namespace app\helpers;

use yii\web\UploadedFile;

class Storage
{
    public static function saveUploadedFile(UploadedFile $uploadedFile, string $filePath): bool
    {
        return $uploadedFile->saveAs(self::getFullPath($filePath));
    }

    public static function delete(string $filePath): bool
    {
        $fullPath = self::getFullPath($filePath);
        if (!file_exists($fullPath)) {
            return false;
        }

        return unlink($fullPath);
    }

    public static function get(string $filePath): string|bool
    {
        $fullPath = self::getFullPath($filePath);
        if (!file_exists($fullPath)) {
            return false;
        }

        return file_get_contents($fullPath);
    }

    private static function getFullPath(string $filePath): string
    {
        return self::getStoragePath() . $filePath;
    }

    private static function getStoragePath(): string
    {
        return \Yii::getAlias('@webroot') . '/storage/';
    }
}