<?php

namespace app\models;

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
}
