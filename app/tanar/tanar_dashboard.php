<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/header.php';

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['felhasznalo_nev'])) {
    header("Location: login.php");
    exit();
}

// Felhasználói típus
$tipus = $_SESSION['felhasznalo_nev'];
?>


    <div class="container">
        <h1>Tanárok Dashboard</h1>

        <div class="dashboard">
            <div class="card col-4">
                <h2>Tárgyak kezelése</h2>
                <a href="../tanar/subjects.php" class="button">Tárgyak listázása</a>
            </div>

            <div class="card col-4">
                <h2>Diákok kezelése</h2>
                <a href="../tanar/students.php" class="button">Diákok listázása</a>
            </div>

            <div class="card col-4">
                <h2>Jegyek kezelése</h2>
                <a href="../tanar/add_grades.php" class="button">Új jegy hozzáadása</a>
                <a href="../tanar/tgrade_list.php" class="button">Jegy módosítása</a>
                <a href="../tanar/tgrade_list.php" class="button">Jegy törlése</a>
            </div>
        </div>
    </div>


