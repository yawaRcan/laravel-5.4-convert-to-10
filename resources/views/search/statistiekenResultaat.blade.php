<div>
    <script>

        window.chartColors = {
            red: 'rgb(255, 0, 0)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(0, 163, 51)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)',
            darkblue: 'rgb(0,0,255)'
        };

        var color = Chart.helpers.color;

        var data_viewer = <?php echo json_encode($resultaten); ?>;
        //alert(data_viewer);
        var myObj = JSON.parse(data_viewer);

        var totfacturen = [];
        var totalen = [];
        var betaald = [];
        var tebetalen = [];
        var labels = [];
        
        for (x in myObj) {
            labels.push(x);
            totfacturen.push(myObj[x].totfacturen);
            totalen.push(myObj[x].totaal);
            betaald.push(myObj[x].betaald);
            tebetalen.push(myObj[x].tebetalen);
        }

        var barChartData = {
            labels: labels,
            datasets: [{
                label: 'Totaal',
                backgroundColor: color(window.chartColors.darkblue).alpha(0.7).rgbString(),
                borderColor: window.chartColors.darkblue,
                borderWidth: 1,
                data: totalen
            },
                {
                    label: 'Betaald',
                    backgroundColor: color(window.chartColors.green).alpha(0.7).rgbString(),
                    borderColor: window.chartColors.green,
                    borderWidth: 1,
                    data: betaald
                },
                {
                    label: 'Te betalen',
                    backgroundColor: color(window.chartColors.red).alpha(0.7).rgbString(),
                    borderColor: window.chartColors.red,
                    borderWidth: 1,
                    data: tebetalen
                }]
        };

        var ctx = document.getElementById('myChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                legend: {
                    position: 'right'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    </script>

    <div class="row">
        <canvas id="myChart"></canvas>
    </div>
</div>

<div class="row">

    <?php
    $jsonIterator = new RecursiveIteratorIterator(
        new RecursiveArrayIterator(json_decode($resultaten, TRUE)),
        RecursiveIteratorIterator::SELF_FIRST);

    $open = 0;
    $aantalgeparset = 0;

    echo '<table class="table table-sm table-striped"><th>Onderverdeling</th><th>Aantal facturen</th><th class="rechts">Totaal facturen</th><th class="rechts">Totaal Betaald</th><th class="rechts">Totaal te betalen</th>';

    foreach ($jsonIterator as $key => $val) {

        if (is_array($val)) {
            $aantalgeparset = 0;
            if ($open == 0) {
                echo "<tr><td>$key</td>";
                $open = 1;
            } else {
                echo "</tr><tr><td>$key</td>";
                $open = 0;
            }
        } else {
            if ($aantalgeparset == 0) {
                echo "<td>".$val."</td>";
                $aantalgeparset =1;
            }
            else {
                echo "<td class='rechts'>" . number_format($val, 2, ",", ".") . " EUR" . " (" . number_format($val * 40.3399, 2, ",", ".") . " BEF)";
            }
        }
    }
        echo "</tr></table><br><br>";
    ?>
</div>