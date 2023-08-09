<?php

namespace app\controllers;

use app\helpers\HtmlParser;
use app\repository\TransactionReportRepository;
use yii\web\Controller;

class ChartController extends Controller
{
    public $layout = false;
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

        // TODO for multiple columns: date & money | also to lowercase when search

        // TODO check statistics (wrong may be)

        $htmlParser = new HtmlParser($html);
        $profits = $htmlParser->getBalance('Profit');
        $times = $htmlParser->getColumnValues('Open Time');

        // var_dump(sizeof($profits), sizeof($times));

        return $this->render('generate', compact('profits', 'times'));
    }
}
