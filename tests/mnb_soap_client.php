<?php
$client = new SoapClient("https://www.mnb.hu/arfolyamok.asmx?WSDL");

function getExchangeRate($currencyPair, $date) {
    global $client;
    return $client->GetExchangeRate(array('currencyPair' => $currencyPair, 'date' => $date));
}

// Lekérdezés példa
$exchangeRate = getExchangeRate('EURHUF', '2023-10-24'); // Példa árfolyam
echo "Az EUR/HUF árfolyam 2023-10-24-én: " . $exchangeRate;

function getMonthlyExchangeRates($currencyPair, $month, $year) {
    $rates = [];
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = sprintf("%04d-%02d-%02d", $year, $month, $day);
        try {
            $rate = getExchangeRate($currencyPair, $date);
            $rates[$date] = $rate;
        } catch (SoapFault $e) {
            // Hibakezelés
            $rates[$date] = null;
        }
    }
    return $rates;
}

// Példa havi árfolyam lekérdezésre
$monthlyRates = getMonthlyExchangeRates('EURHUF', 10, 2023); // 2023. október
echo "<pre>";
print_r($monthlyRates);
echo "</pre>";

?>

<canvas id="exchangeRateChart"></canvas>
<script>
    const ctx = document.getElementById('exchangeRateChart').getContext('2d');
    const labels = <?php echo json_encode(array_keys($monthlyRates)); ?>;
    const data = <?php echo json_encode(array_values($monthlyRates)); ?>;

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'EUR/HUF árfolyam',
                data: data,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

