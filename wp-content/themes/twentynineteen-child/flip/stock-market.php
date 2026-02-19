<?php
// replace the "demo" apikey below with your own key from https://www.alphavantage.co/support/#api-key
$json = file_get_contents('https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=IBM&apikey=demo');

$data = json_decode($json,true);

print_r($data);

exit
?>