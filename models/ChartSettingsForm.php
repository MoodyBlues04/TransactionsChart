<?php

namespace app\models;

use yii\base\Model;

class ChartSettingsForm extends Model
{
    public ?int $transactionReportId = null;
    public ?string $balanceColumnName = null;
    public ?string $timeColumnName = null;

    public function rules(): array
    {
        return [
            [['transactionReportId', 'balanceColumnName', 'timeColumnName'], 'required'],
            [['transactionReportId'], 'integer'],
            [['balanceColumnName', 'timeColumnName'], 'string'],
        ];
    }

    /**
     * @throws \Exception
     */
    public function loadPostData(): void
    {
        if (!$this->load(\Yii::$app->request->post())) {
            throw new \Exception('Form data not loaded');
        }
        if (!$this->validate()) {
            throw new \Exception('Invalid form data');
        }
    }
}
