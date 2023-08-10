<?php

namespace app\traits;

trait ErrorHandler
{
    public function hanleAndRedirect(\Exception $e): void
    {
        $this->handle($e);
        \Yii::$app->response->redirect(\Yii::$app->request->referrer ?: \Yii::$app->homeUrl)->send();
    }

    public function handle(\Exception $e)
    {
        \Yii::error($e->getMessage());
        \Yii::$app->session->setFlash('error', $e->getMessage());
    }
}
