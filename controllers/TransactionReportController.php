<?php

namespace app\controllers;

use app\models\TransactionReport;
use app\models\TransactionReportForm;
use app\repository\TransactionReportRepository;
use app\traits\ErrorHandler;
use yii\web\Controller;

class TransactionReportController extends Controller
{
    use ErrorHandler;

    private TransactionReportRepository $transactionReportRepository;

    public function __construct($id, $module, $config = [], TransactionReportRepository $transactionReportRepository)
    {
        parent::__construct($id, $module, $config);
        $this->transactionReportRepository = $transactionReportRepository;
    }

    // TODO mb simple unit tests

    public function actionIndex()
    {
        $transactionReports = TransactionReport::find()->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('index', compact('transactionReports'));
    }

    public function actionCreate()
    {
        $transactionReportForm = new TransactionReportForm();

        return $this->render('create', compact('transactionReportForm'));
    }

    public function actionStore()
    {
        try {
            $transactionReportForm = new TransactionReportForm();
            $transactionReportForm->loadPostData();

            // TODO to ActiveRecord model / repo
            $transactionReportForm->save();

            return $this->redirect('./index');
        } catch (\Exception $e) {
            $this->hanleAndRedirect($e);
        }
    }

    public function actionDelete()
    {
        try {
            // TODO to obj ???
            $transactionReportId = \Yii::$app->request->post('id');
            if (is_null($transactionReportId)) {
                throw new \Exception('Report id is required');
            }

            $transactionReport = $this->transactionReportRepository->getById($transactionReportId);
            if (is_null($transactionReport)) {
                throw new \Exception('Invalid report id');
            }

            $transactionReport->delete();

            return $this->redirect('./index');
        } catch (\Exception $e) {
            $this->hanleAndRedirect($e);
        }
    }
}
