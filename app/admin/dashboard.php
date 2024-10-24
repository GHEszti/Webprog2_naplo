<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/adminheader.php';

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

<body>
    <div class="container">
        <h1>Admin Dashboard</h1>

        <div class="dashboard">
            <div class="card col-4">
                <h2>Tárgyak kezelése</h2>
                <a href="../admin/add_subject.php" class="button">Új tárgy hozzáadása</a>
                <a href="../admin/subject_list.php" class="button">Tárgy módosítása</a>
                <a href="../admin/subject_list.php" class="button">Tárgy törlése</a>
            </div>

            <div class="card col-4">
                <h2>Diákok kezelése</h2>
                <a href="../admin/add_student.php" class="button">Új diák hozzáadása</a>
                <a href="../admin/student_list.php" class="button">Diák módosítása</a>
                <a href="../admin/student_list.php" class="button">Diák törlése</a>
            </div>

            <div class="card col-4">
                <h2>Jegyek kezelése</h2>
                <a href="../admin/add_grade.php" class="button">Új jegy hozzáadása</a>
                <a href="../admin/grade_list.php" class="button">Jegy módosítása</a>
                <a href="../admin/grade_list.php" class="button">Jegy törlése</a>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

