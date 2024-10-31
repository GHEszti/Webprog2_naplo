<?php
$client = new SoapClient("http://localhost:8080/phpmyadmin/index.php?route=/database/structure&db=feladat");

try {
    // Példa: diák jegyeinek lekérése
    $studentId = 1; // Példa diák ID
    $grades = $client->getStudentGrades($studentId);
    echo "<pre>";
    print_r($grades);
    echo "</pre>";
} catch (SoapFault $e) {
    echo "SOAP hiba: " . $e->getMessage();
}
?>
