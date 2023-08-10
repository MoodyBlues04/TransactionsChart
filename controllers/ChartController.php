<?php

namespace app\controllers;

use app\repository\TransactionReportRepository;
use app\traits\ErrorHandler;
use yii\web\Controller;

class ChartController extends Controller
{
    use ErrorHandler;

    public $layout = false;
    private TransactionReportRepository $transactionReportRepository;

    public function __construct($id, $module, $config = [], TransactionReportRepository $transactionReportRepository)
    {
        parent::__construct($id, $module, $config);
        $this->transactionReportRepository = $transactionReportRepository;
    }

    public function actionGenerate()
    {
        try {
            $transactionReportId = \Yii::$app->request->get('transaction_report');
            if (is_null($transactionReportId)) {
                throw new \Exception('Report id is required');
            }

            $transactionReport = $this->transactionReportRepository->getById($transactionReportId);
            if (is_null($transactionReport)) {
                throw new \Exception('Invalid report id');
            }

            // TODO to lowercase when search
            $balance = $transactionReport->getBalanceReport('Profit', 'Open Time');

            $balances = $balance->getBalance();
            $times = $balance->getTime();

            return $this->render('generate', compact('balances', 'times'));
        } catch (\Exception $e) {
            $this->hanleAndRedirect($e);
        }
    }
}
