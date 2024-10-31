<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/header.php';

$error_message = ""; // Hibaüzenet inicializálása

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $felhasznalonev = $_POST['felhasznalonev']; 
    $jelszo = $_POST['jelszo'];

    // Felhasználó lekérdezése az adatbázisból
    $stmt = $conn->prepare("SELECT * FROM felhasznalo WHERE felhasznalo_nev = ?");
    if ($stmt === false) {
        $error_message = 'Hiba az előkészített lekérdezésben: ' . $conn->error;
    } else {
        $stmt->bind_param("s", $felhasznalonev);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $felhasznalo = $result->fetch_assoc();

            // Jelszó ellenőrzése
            if ($jelszo == $felhasznalo['jelszo']) {
                // Felhasználói adatok session-be mentése
                $_SESSION['felhasznalo_nev'] = $felhasznalo['felhasznalo_nev'];

                // Felhasználói típus alapján átirányítás
                switch ($felhasznalo['felhasznalo_nev']) {
                    case 'admin':
                        header("Location: ../admin/dashboard.php");
                        exit();
                    case 'tanar':
                        header("Location: ../tanar/tanar_dashboard.php");
                        exit();
                    case 'diak':
                        header("Location: ../diak/diak_dashboard.php");
                        exit();
                    default:
                        $error_message = "Ismeretlen felhasználói típus!";
                }
            } else {
                $error_message = "Hibás jelszó!";
            }
        } else {
            $error_message = "Nincs ilyen felhasználó!";
        }
    }
}
?>

<div class="container">
<h1>Bejelentkezés</h1>
<?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
<form method="POST" action="">
    <label for="felhasznalonev">Felhasználónév:</label>
    <input type="text" name="felhasznalonev" id="felhasznalonev" required>
    <label for="jelszo">Jelszó:</label>
    <input type="password" name="jelszo" id="jelszo" required>
    <button type="submit">Bejelentkezés</button>
</form>
</div>
