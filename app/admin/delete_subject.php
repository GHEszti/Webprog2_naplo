<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/adminheader.php';

// Ellenőrizzük, hogy az id létezik-e a GET paraméterben
if (!isset($_GET['id'])) {
    echo "Hiányzó tárgy ID!";
    exit();
}

$subject_id = $_GET['id'];

// Lekérjük a törölni kívánt tárgy adatait
$stmt = $conn->prepare("SELECT nev, kategoria FROM targy WHERE id = ?");
$stmt->bind_param("i", $subject_id);
$stmt->execute();
$result = $stmt->get_result();
$subject = $result->fetch_assoc();

// Ha nem találunk ilyen tárgyat
if (!$subject) {
    echo "A megadott ID-val nem található tárgy.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Tárgy törlése az adatbázisból
    $stmt = $conn->prepare("DELETE FROM targy WHERE id = ?");
    $stmt->bind_param("i", $subject_id);
    
    if ($stmt->execute()) {
        echo "Tárgy törölve!";
        // Itt esetleg átirányíthatod a felhasználót a tantárgyak listájára
        header("Location: subject_list.php");
        exit();
    } else {
        echo "Hiba a törlés során: " . $stmt->error;
    }
}
?>

<div class="container">
    <h1>Tárgy Törlése</h1>
    <p>Biztosan törölni szeretnéd a következő tárgyat?</p>
    
    <!-- Törölni kívánt tárgy adatai -->
    <p><strong>Tárgy neve:</strong> <?php echo htmlspecialchars($subject['nev']); ?></p>
    <p><strong>Kategória:</strong> <?php echo htmlspecialchars($subject['kategoria']); ?></p>

    <form method="POST" action="">
        <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
        <button type="submit">Igen, törlés</button>
    </form>
    <a href="../admin/subject_list.php">Mégse</a>
</div>

<?php include '../includes/footer.php'; ?>
