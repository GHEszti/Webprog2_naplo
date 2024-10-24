<?php
$servername = "localhost"; // vagy az adatbázis szerver címe
$username = "root"; // Adatbázis felhasználónév
$password = ""; // Adatbázis jelszó
$dbname = "feladat"; // Az adatbázis neve

// Kapcsolat létrehozása
$conn = new mysqli($servername, $username, $password, $dbname);

// Ellenőrzés
if ($conn->connect_error) {
    die("Kapcsolati hiba: " . $conn->connect_error);
}
?>
