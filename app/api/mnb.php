<?php
// MNB SOAP interfész implementációja
class MNBService {
    public function getExchangeRate($currencyPair, $date) {
        // MNB SOAP lekérdezés implementációja
        $client = new SoapClient("https://www.mnb.hu/arfolyamok.asmx?WSDL");
        $params = ['devizaPaar' => $currencyPair, 'datum' => $date];
        $response = $client->__soapCall('GetArfolyam', [$params]);
        return $response;
    }
}

// SOAP szerver beállítása
$options = array('uri' => 'http://localhost/');
$server = new SoapServer(null, $options);
$server->setClass('MNBService');
$server->handle();
?>
