<?php

namespace app\controllers;

use app\models\TransactionReport;
use app\models\TransactionReportForm;
use yii\web\Controller;

class TransactionReportController extends Controller
{
    // TODO dependency injection for repo & mb simple unit tests

    // TODO all files form storage show
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

            if (!$transactionReportForm->upload()) {
                throw new \Exception('Invalid transaction report, not uploaded');
            }

            $transactionReport = new TransactionReport();
            $transactionReport->path = $transactionReportForm->getPublicPath();
            if (!$transactionReport->save()) {
                throw new \Exception('Path not saved to database');
            }

            return $this->redirect('./index');
        } catch (\Exception $e) {
            // TODO logging
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer ?: \Yii::$app->homeUrl);
        }
    }

    public function actionDelete()
    {
        var_dump(\Yii::$app->request->post());
    }
}
