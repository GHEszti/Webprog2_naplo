<?php
$servername = "localhost"; // vagy az adatbázis szerver címe
$username = "te_naplo"; // Adatbázis felhasználónév
$password = "peszto123"; // Adatbázis jelszó
$dbname = "te_naplo"; // Az adatbázis neve

// Kapcsolat létrehozása
$conn = new mysqli($servername, $username, $password, $dbname);

// Ellenőrzés
if ($conn->connect_error) {
    die("Kapcsolati hiba: " . $conn->connect_error);
}
?>
