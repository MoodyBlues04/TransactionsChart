<?php

namespace app\assets;

class ChartAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/npm-asset';

    public $js = [
        'chart.js/dist/core/core.controller.d.js',
    ];
}
