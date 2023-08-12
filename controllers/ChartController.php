<?php

namespace app\controllers;

use app\models\ChartSettingsForm;
use app\repository\TransactionReportRepository;
use app\requests\Request;
use app\traits\ErrorHandler;
use yii\web\Controller;

class ChartController extends Controller
{
    use ErrorHandler;

    private TransactionReportRepository $transactionReportRepository;

    public function __construct($id, $module, $config = [], TransactionReportRepository $transactionReportRepository)
    {
        parent::__construct($id, $module, $config);
        $this->transactionReportRepository = $transactionReportRepository;
    }

    public function actionChartSettings()
    {
        try {
            throw new \Exception('test');
            $request = new Request();
            $transactionReportId = $request->getGetParamOrFail('transaction_report', 'Report id is required');

            $chartSettingsForm = new ChartSettingsForm();

            return $this->render('chart-settings', compact('transactionReportId', 'chartSettingsForm'));
        } catch (\EXception $e) {
            $this->hanleAndRedirect($e);
        }
    }

    public function actionGenerate()
    {
        try {
            $chartSettingsForm = new ChartSettingsForm();
            $chartSettingsForm->loadPostData();

            $transactionReport = $this->transactionReportRepository->getByIdOrFail($chartSettingsForm->transactionReportId);

            $balance = $transactionReport->getBalanceReport(
                $chartSettingsForm->balanceColumnName,
                $chartSettingsForm->timeColumnName
            );

            $balances = $balance->getBalance();
            $times = $balance->getTime();

            return $this->renderPartial('generate', compact('balances', 'times'));
        } catch (\Exception $e) {
            $this->hanleAndRedirect($e);
        }
    }
}
