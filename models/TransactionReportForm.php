<?php

namespace app\models;

use app\helpers\Storage;
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

    /**
     * @throws \Exception
     */
    public function save(): TransactionReport
    {
        $transactionReportPath = $this->uploadTransactionReport();

        return $this->saveTransactionReport($transactionReportPath);
    }

    /**
     * @throws \Exception
     */
    private function uploadTransactionReport(): string
    {
        if (!$this->validate()) {
            throw new \Exception('Invalid file');
        }

        $transactionReportPath =  $this->getPublicPath();
        if (!Storage::saveUploadedFile($this->transactionReport, $transactionReportPath)) {
            throw new \Exception('File not saved');
        }

        return $transactionReportPath;
    }

    /**
     * @throws \Exception
     */
    private function saveTransactionReport(string $path): TransactionReport
    {
        $transactionReport = new TransactionReport();
        $transactionReport->path = $path;
        if (!$transactionReport->save()) {
            throw new \Exception('Path not saved to DB');
        }

        return $transactionReport;
    }

    private function getPublicPath(): string
    {
        return "{$this->transactionReport->baseName}-{$this->timestamp()}.{$this->transactionReport->extension}";
    }

    private function timestamp(): string
    {
        return (string)time();
    }
}
