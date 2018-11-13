<?php

    $xml = simplexml_load_file("https://query.yahooapis.com/v1/public/yql?env=store://datatables.org/alltableswithkeys&format=xml&q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text=%22yogyakarta%22)");

    $result = $xml->results->channel;

    echo htmlentities($var, ENT_QUOTES, 'utf-8');
?>
