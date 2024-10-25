<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $felhasznalonev = $_POST['felhasznalonev']; 
    $jelszo = $_POST['jelszo'];

    // Felhasználó lekérdezése az adatbázisból
    $stmt = $conn->prepare("SELECT * FROM felhasznalo WHERE felhasznalo_nev = ?");
    if ($stmt === false) {
        die('Hiba az előkészített lekérdezésben: ' . $conn->error);
    }

    $stmt->bind_param("s", $felhasznalonev);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $felhasznalo = $result->fetch_assoc();

        // Jelszó ellenőrzése
        if ($jelszo == $felhasznalo['jelszo']) {
            // Felhasználói adatok session-be mentése
            $_SESSION['felhasznalo_nev'] = $felhasznalo['felhasznalo_nev'];
            $_SESSION['felhasznalo_nev'] = $felhasznalo['felhasznalo_nev']; // Szerepkör hozzáadása a session-höz

            // Felhasználói típus alapján átirányítás
            switch ($felhasznalo['felhasznalo_nev']) { // Itt most a szerepkört használjuk
                case 'admin':
                    header("Location: ../admin/dashboard.php");
                    break;
                case 'tanar':
                    header("Location: ../tanar/tanar_dashboard.php");
                    break;
                case 'diak':
                    header("Location: ../diak/diak_dashboard.php");
                    break;
                default:
                    echo "Ismeretlen felhasználói típus!";
                    break;
            }
        } else {
            echo "Hibás jelszó!";
        }
    } else {
        echo "Nincs ilyen felhasználó!";
    }
}
?>

<div class="container">
<h1>Bejelentkezés</h1>
<form method="POST" action="">
    <label for="felhasznalonev">Felhasználónév:</label>
    <input type="text" name="felhasznalonev" id="felhasznalonev" required>
    <label for="jelszo">Jelszó:</label>
    <input type="password" name="jelszo" id="jelszo" required>
    <button type="submit">Bejelentkezés</button>
</form>
</div>
