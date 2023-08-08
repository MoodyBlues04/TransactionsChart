<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\TransactionReportForm;

/**
 * @var TransactionReportForm $transactionReportForm
 */
?>

<div class="row align-items-center">
    <div class="col-6 offset-3">
        <div class="card">
            <div class="form">
                <div class="card-header">
                    <h5 class="card-title">Generate chart</h5>
                </div>
                <div class="card-body">
                    <?php
                    $form = ActiveForm::begin([
                        'action' => ['/transaction-report/store'],
                        'options' => ['method' => 'post']
                    ]); ?>

                    <?= $form->field($transactionReportForm, 'transactionReport')->fileInput([
                        'class' => 'form-control'
                    ])->label(false) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>