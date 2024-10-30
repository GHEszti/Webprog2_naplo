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

// Diák adatok lekérdezése
$query = "SELECT * FROM diak WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];
    $student_osztaly = $_POST['student_osztaly'];
    
    // Frissítés végrehajtása
    $stmt = $conn->prepare("UPDATE diak SET nev = ?, osztaly = ? WHERE id = ?");
    $stmt->bind_param("ssi", $student_name, $student_osztaly, $student_id);
    
    if ($stmt->execute()) {
        echo "Diák módosítva!";
        // Itt lehet átirányítani a diákok listájára, ha szükséges
        header("Location: student_list.php");
        exit();
    } else {
        echo "Hiba a módosítás során: " . $stmt->error;
    }
}
?>

<div class="container">
    <h1>Diák Módosítása</h1>
    <form method="POST" action="">
        <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
        
        <label for="student_name">Diák neve:</label>
        <input type="text" name="student_name" value="<?php echo htmlspecialchars($student['nev']); ?>" required>
        
        <label for="student_osztaly">Osztály:</label>
        <input type="text" name="student_osztaly" value="<?php echo htmlspecialchars($student['osztaly']); ?>" required>

        <button type="submit">Módosítás</button>
        <a href="../admin/student_list.php" class="btn btn-outline-dark">Vissza a diákok listájához</a>
    </form>
</div>

