<?php

/** @var array $balances */
/** @var array $times */

?>

<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title>Chart</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="d-flex flex-column h-100">
    <div>
        <button onclick="downloadChart()">Download</button>
        <canvas id="myChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('myChart');

        const data = <?= json_encode($balances) ?>;
        const labels = <?= json_encode($times) ?>;

        let chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Profit',
                    data: data,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        title: {
                            display: true,
                            text: 'Value'
                        }
                    }
                },
                interaction: {
                    intersect: false
                },
            }
        });

        function downloadChart() {
            let a = document.createElement('a');
            a.href = chart.toBase64Image();
            a.download = `chart${Date.now()}.png`;

            a.click();
        }
    </script>
</body>