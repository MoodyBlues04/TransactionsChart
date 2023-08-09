<?php

namespace app\models;

use app\helpers\Storage;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * @property int $id
 * @property string $path
 * @property string $created_at
 * @property string $updated_at
 */
class TransactionReport extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%transaction_reports}}';
    }

    public function beforeDelete(): bool
    {
        Storage::delete($this->path);
        return parent::beforeDelete();
    }
}
