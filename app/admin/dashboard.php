<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/header.php';

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['felhasznalo_nev'])) {
    header("Location: index.php");
    exit();
}

// Felhasználói típus
$tipus = $_SESSION['felhasznalo_nev'];
?>

<body>
    <div class="container">
        <h1>Admin kezdőlap</h1>

        <div class="dashboard">
            <div class="card col-4">
                <h2>Tárgyak kezelése</h2>
                <a href="../admin/add_subject.php" class="newb button">Új tárgy hozzáadása</a>
                <a href="../admin/subject_list.php" class="editb button">Tárgy módosítása</a>
                <a href="../admin/subject_list.php" class="deleteb button">Tárgy törlése</a>
            </div>

            <div class="card col-4">
                <h2>Diákok kezelése</h2>
                <a href="../admin/add_student.php" class="newb button">Új diák hozzáadása</a>
                <a href="../admin/student_list.php" class="editb button">Diák módosítása</a>
                <a href="../admin/student_list.php" class="deleteb button">Diák törlése</a>
            </div>

            <div class="card col-4">
                <h2>Jegyek kezelése</h2>
                <a href="../admin/add_grade.php" class="newb button">Új jegy hozzáadása</a>
                <a href="../admin/grade_list.php" class="editb button">Jegy módosítása</a>
                <a href="../admin/grade_list.php" class="deleteb button">Jegy törlése</a>
            </div>
        </div>
    </div>

 
