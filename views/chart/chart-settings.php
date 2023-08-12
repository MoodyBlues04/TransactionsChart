<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\ChartSettingsForm;

/**
 * @var ChartSettingsForm $chartSettingsForm
 * @var int $transactionReportId
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
                        'action' => ['/chart/generate'],
                        'options' => ['method' => 'post']
                    ]); ?>

                    <?= $form->field($chartSettingsForm, 'transactionReportId')->hiddenInput([
                        'class' => 'form-control',
                        'value' => $transactionReportId
                    ])->label(false) ?>

                    <?= $form->field($chartSettingsForm, 'balanceColumnName')->textInput([
                        'class' => 'form-control',
                    ])->label('Balance column name') ?>

                    <?= $form->field($chartSettingsForm, 'timeColumnName')->textInput([
                        'class' => 'form-control',
                    ])->label('Time column name') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>