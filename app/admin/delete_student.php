<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/header.php';

// Diák ID lekérdezése
$student_id = $_GET['id'];

// Ellenőrizzük, hogy az ID létezik-e
if (!isset($student_id)) {
    echo "Hiányzó diák ID!";
    exit();
}

// Lekérjük a törölni kívánt diák adatait
$query = "SELECT nev, osztaly FROM diak WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Ha nem találunk ilyen diákot
if (!$student) {
    echo "A megadott ID-val nem található diák.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Diák törlése az adatbázisból
    $stmt = $conn->prepare("DELETE FROM diak WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    
    if ($stmt->execute()) {
        echo "Diák törölve!";
        // Átirányítás a diákok listájára törlés után, ha szükséges
        header("Location: student_list.php");
        exit();
    } else {
        echo "Hiba a törlés során: " . $stmt->error;
    }
}
?>

<div class="container">
    <h1>Diák Törlése</h1>
    <p>Biztosan törölni szeretnéd a diákot?</p>
    
    <!-- Törölni kívánt diák adatai -->
    <form method="POST" action="">
        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
        <p><strong>Diák neve:</strong> <?php echo htmlspecialchars($student['nev']); ?></p>
        <p><strong>Osztály:</strong> <?php echo htmlspecialchars($student['osztaly']); ?></p>
    
        <button type="submit">Törlés</button>
    </form>
    <a href="../admin/student_list.php" class="btn btn-outline-dark">Vissza a diákok listájához</a>
</div>
