<?php

/** @var array $balances */
/** @var array $times */

?>

<div>
    <canvas id="myChart"></canvas>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('myChart');

const data = <?= json_encode($balances) ?>;
const labels = <?= json_encode($times) ?>;

const onRefresh = chart => {
    const now = Date.now();
    chart.data.datasets.forEach(dataset => {
        dataset.data.push({
            x: now,
            y: Utils.rand(-100, 100)
        });
    });
};

new Chart(ctx, {
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
            x: {
                realtime: {
                    duration: 20000,
                    refresh: 1000,
                    delay: 2000,
                    onRefresh: onRefresh
                },
                // type: 'realtime'
            },
            y: {
                title: {
                    display: true,
                    text: 'Value'
                }
            }
        },
        interaction: {
            intersect: false
        }
    }
});
</script>