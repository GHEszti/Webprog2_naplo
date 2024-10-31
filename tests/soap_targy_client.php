<?php
$client = new SoapClient(null, ['location' => "http://yourdomain.com/targy_server.php", 'uri' => "http://yourdomain.com"]);
try {
    $subjects = $client->getAllSubjects();
    print_r($subjects);
} catch (Exception $e) {
    echo "Hiba: " . $e->getMessage();
}

?>