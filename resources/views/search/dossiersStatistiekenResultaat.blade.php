<div class="row">
    <p>Groot totaal van alle dossiers : {{ number_format($grandtotal, 2, "," , ".") }} EUR / {{ number_format($grandtotal * 40.3399, 2, "," , ".") }} BEF</p>
    <p>Totaal aantal dossiers : {{ $totdossiers }}</p>
    <hr>
</div>

<div class="row">
    <canvas id="myChart"></canvas>
    <canvas id="mySecondChart"></canvas>
    <canvas id="myThirdChart"></canvas>
</div>

<div class="row">
    <?php
    $jsonIterator = new RecursiveIteratorIterator(
        new RecursiveArrayIterator(json_decode($resultaten, TRUE)),
        RecursiveIteratorIterator::SELF_FIRST);

    $open = 0;

    echo '<table class="table table-sm table-striped tablesorter" id="myTable"><thead><tr><th>Makelaar</th><th class="rechts">Tot # dossiers</th><th class="rechts">F</th><th class="rechts">NF</th><th class="rechts">% Bedrag</th><th class="rechts">% Dossiers</th><th class="rechts">Tot (EUR)</th><th class="rechts">Tot (BEF)</th></tr></thead><tbody>';

    foreach ($jsonIterator as $key => $val) {
        if (is_array($val)) {
            if ($open == 0) {
                echo "<tr><td>$key</td>";
                $open = 1;
            } else {
                echo "</tr><tr><td>$key</td>";
                $open = 0;
            }
        } else {
            if ($key == "percent" || $key == "percentdossiers") {
                echo "<td class='rechts'>$val%</td>";
            }
            elseif ($key == "totaal") {
                echo "<td class='rechts'>" . number_format($val, 2, ",", ".") . "</td>";
            }
            elseif ($key == "totbef") {
                echo "<td class='rechts'>" . number_format($val, 2, ",", ".") . "</td>";
            }
            elseif ($key == "aantal" || $key == "aantaldossiersgefactureerd" || $key == "aantaldossiersnietgefactureerd") {
                echo "<td class='rechts'>$val</td>";
            }
            else {echo "<td>$val</td>";}
        }
    }
    echo "</tr></tbody></table><br><br>";
    ?>
</div>

<div class="row">

    <h1>Kleine partijen (< 5 dossiers)</h1>
    <hr>
    <?php
    $jsonIterator = new RecursiveIteratorIterator(
        new RecursiveArrayIterator(json_decode($kleinemakelaars, TRUE)),
        RecursiveIteratorIterator::SELF_FIRST);

    $open = 0;

    echo '<table class="table table-sm table-striped tablesorter" id="myTable"><thead><tr><th>Makelaar</th><th class="rechts">Tot # dossiers</th><th class="rechts">F</th><th class="rechts">NF</th><th class="rechts">% Bedrag</th><th class="rechts">% Dossiers</th><th class="rechts">Tot (EUR)</th><th class="rechts">Tot (BEF)</th></tr></thead><tbody>';

    foreach ($jsonIterator as $key => $val) {
        if (is_array($val)) {
            if ($open == 0) {
                echo "<tr><td>$key</td>";
                $open = 1;
            } else {
                echo "</tr><tr><td>$key</td>";
                $open = 0;
            }
        } else {
            if ($key == "percent" || $key == "percentdossiers") {
                echo "<td class='rechts'>$val%</td>";
            }
            elseif ($key == "totaal") {
                echo "<td class='rechts'>" . number_format($val, 2, ",", ".") . " EUR</td>";
            }
            elseif ($key == "totbef") {
                echo "<td class='rechts'>" . number_format($val, 2, ",", ".") . " BEF</td>";
            }
            elseif ($key == "aantal" || $key == "aantaldossiersgefactureerd" || $key == "aantaldossiersnietgefactureerd") {
                echo "<td class='rechts'>$val</td>";
            }
            else {echo "<td>$val</td>";}
        }
    }
    echo "</tr></tbody></table><br><br>";
    ?>
</div>



    <script>
        var data_viewer = <?php echo json_encode($resultaten); ?>;

        var myObj = JSON.parse(data_viewer);

        var totalen = [];
        var labels = [];
        var aantallen = [];
        var percent = [];

        for (x in myObj) {
            labels.push(x);
            totalen.push(myObj[x].totaal);
            aantallen.push(myObj[x].aantal);
            percent.push(myObj[x].percent);
        }

        var ctx = document.getElementById('myChart').getContext('2d');

        var graphColors = [];

        var internalDataLength = totalen.length;
        i = 0;

        while (i <= internalDataLength) {
            var randomR = Math.floor((Math.random() * 130) + 100);
            var randomG = Math.floor((Math.random() * 130) + 100);
            var randomB = Math.floor((Math.random() * 130) + 100);

            var graphBackground = "rgb("
                + randomR + ", "
                + randomG + ", "
                + randomB + ")";
            graphColors.push(graphBackground);

            i++;
        };

        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: totalen,
                    backgroundColor: graphColors,
                    //borderColor: window.chartColors.darkblue,
                }],
            },
            options: {
                legend: {
                    display: false,
                    position: 'right',
                    fontsize: 8,
                    boxWidth: 5,
                },
                title: {
                    display: true,
                    position: 'top',
                    text: "Totaal dossier bedrag per <?php echo $titel; ?>",
                    fontsize: 35,
                }
            }
        });
        /*
         var graphOutlines = [];
         var hoverColor = [];
         hoverBackgroundColor: hoverColor,
         borderColor: graphOutlines
         */


        var ctx = document.getElementById('mySecondChart').getContext('2d');

        var graphColors = [];

        var internalDataLength = aantallen.length;
        i = 0;

        while (i <= internalDataLength) {
            var randomR = Math.floor((Math.random() * 130) + 100);
            var randomG = Math.floor((Math.random() * 130) + 100);
            var randomB = Math.floor((Math.random() * 130) + 100);

            var graphBackground = "rgb("
                + randomR + ", "
                + randomG + ", "
                + randomB + ")";
            graphColors.push(graphBackground);

            i++;
        };

        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: aantallen,
                    backgroundColor: graphColors,
                    //borderColor: window.chartColors.darkblue,
                }],
            },
            options: {
                legend: {
                    display: false,
                    position: 'right',
                    fontsize: 8,
                    boxWidth: 5,
                },
                title: {
                    display: true,
                    position: 'top',
                    text: "Aantal dossiers per <?php echo $titel; ?>",
                    fontsize: 35,
                },
            }
        });


        var ctx = document.getElementById('myThirdChart').getContext('2d');

        var graphColors = [];

        var internalDataLength = percent.length;
        i = 0;

        while (i <= internalDataLength) {
            var randomR = Math.floor((Math.random() * 130) + 100);
            var randomG = Math.floor((Math.random() * 130) + 100);
            var randomB = Math.floor((Math.random() * 130) + 100);

            var graphBackground = "rgb("
                + randomR + ", "
                + randomG + ", "
                + randomB + ")";
            graphColors.push(graphBackground);

            i++;
        };

        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: percent,
                    backgroundColor: graphColors,
                    //borderColor: window.chartColors.darkblue,
                }],
            },
            options: {
                legend: {
                    display: false,
                    position: 'right',
                    fontsize: 8,
                    boxWidth: 5,
                },
                title: {
                    display: true,
                    position: 'top',
                    text: "Dossiers bedrag percentage",
                    fontsize: 35,
                },
            }
        });

    </script>