<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class TransactionReportForm extends Model
{
    public ?UploadedFile $transactionReport = null;

    public function rules(): array
    {
        return [
            [['transactionReport'], 'file', 'skipOnEmpty' => false, 'extensions' => 'html']
        ];
    }

    public function loadPostData(): void
    {
        $this->transactionReport = UploadedFile::getInstance($this, 'transactionReport');
    }

    public function upload(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        return $this->transactionReport->saveAs($this->getTransactionReportStoragePath());
    }

    public function getPublicPath(): string
    {
        return "/storage/{$this->transactionReport->baseName}.{$this->transactionReport->extension}";
    }

    private function getTransactionReportStoragePath(): string
    {
        return \Yii::getAlias('@webroot') . $this->getPublicPath();
    }
}
