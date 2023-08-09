<?php

/** @var array $profits */

use app\assets\ChartAsset;
use practically\chartjs\Chart;

ChartAsset::register($this);
?>

<?= Chart::widget([
    'type' => Chart::TYPE_LINE,
    'datasets' => [
        [
            // 'label' => 'test',
            // 'data' => array_map(fn ($profit) => (float)$profit, $profits),
            // 'label' => 'test',
            'data' => [
                't1' => 1,
                't2' => 2
            ]
        ]
    ]
]);
?>