<?php

namespace app\models;

use app\dto\Balance;
use app\helpers\HtmlParser;
use app\helpers\Storage;
use yii\db\ActiveRecord;

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

    public function getReportFile(): string|bool
    {
        return Storage::get($this->path);
    }

    public function getBalanceReport(string $balanceColumnName, string $timeColumnName): Balance
    {
        $html = $this->getReportFile();

        $htmlParser = new HtmlParser($html);
        return $htmlParser->getBalance($balanceColumnName, $timeColumnName);
    }
}
