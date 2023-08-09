<?php

namespace app\controllers;

use app\helpers\HtmlParser;
use app\repository\TransactionReportRepository;
use yii\web\Controller;

class ChartController extends Controller
{
    private TransactionReportRepository $transactionReportRepository;

    public function __construct($id, $module, $config = [], TransactionReportRepository $transactionReportRepository)
    {
        parent::__construct($id, $module, $config);
        $this->transactionReportRepository = $transactionReportRepository;
    }

    public function actionGenerate()
    {
        $transactionReportId = \Yii::$app->request->get('transaction_report');
        if (is_null($transactionReportId)) {
            throw new \Exception('Report id is required');
        }

        $transactionReport = $this->transactionReportRepository->getById($transactionReportId);
        if (is_null($transactionReport)) {
            throw new \Exception('Invalid report id');
        }

        $html = $transactionReport->getReportFile();

        $profitCOlumnValues = (new HtmlParser($html))->getColumnValues('Profit');

        exit;
    }
}
