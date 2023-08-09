<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'TransactionReports', 'url' => ['/transaction-report/index']],
            ]
        ]);
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main" style="background-color:#f3f6f4; height: 100%">
        <div class="container">
            <div class="row">
                <div class="col-8 offset-2">
                    <?php if (Yii::$app->session->hasFlash('success')) : ?>
                        <div class="alert alert-success alert-dismissable">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4><i class="icon fa fa-check"></i>Success</h4>
                                    <?= Yii::$app->session->getFlash('success') ?>
                                </div>
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button" style="width: 27px; height: 27px;">×</button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (Yii::$app->session->hasFlash('error')) : ?>
                        <div class="alert alert-danger alert-dismissable">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4><i class="icon fa fa-check"></i>Error</h4>
                                    <?= Yii::$app->session->getFlash('error') ?>
                                </div>
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button" style="width: 27px; height: 27px;">×</button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?= $content ?>
        </div>
    </main>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>