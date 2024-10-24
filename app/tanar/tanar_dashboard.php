<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/tanarheader.php';

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['felhasznalo_nev'])) {
    header("Location: login.php");
    exit();
}

// Felhasználói típus
$tipus = $_SESSION['felhasznalo_nev'];
?>
<style>
    .dashboard {
    display: flex; /* Rugalmas elrendezés */
    justify-content: space-around; /* Helyezze a kártyákat egyenlően */
    margin-bottom: 20px;
}

.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 30%; /* A kártyák szélessége */
    text-align: center;
}

.card h2 {
    margin-top: 0;
}

.button {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    background: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    text-decoration: none;
}

.button:hover {
    background: #0056b3;
}
    </style>


    <div class="container">
        <h1>Tanárok Dashboard</h1>

        <div class="dashboard">
            <div class="card col-4">
                <h2>Tárgyak kezelése</h2>
                <a href="tanar/subjects.php" class="button">Tárgyak listázása</a>
            </div>

            <div class="card col-4">
                <h2>Diákok kezelése</h2>
                <a href="tanar/students.php" class="button">Diákok listázása</a>
            </div>

            <div class="card col-4">
                <h2>Jegyek kezelése</h2>
                <a href="tanar/add_grades.php" class="button">Új jegy hozzáadása</a>
                <a href="tanar/tgrade_list.php" class="button">Jegy módosítása</a>
                <a href="tanar/tgrade_list.php" class="button">Jegy törlése</a>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

