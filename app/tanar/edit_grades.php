<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $grade_id = $_POST['grade_id'];
    $value = $_POST['value'];
    $date = $_POST['date'];
    $type = $_POST['type'];
    $subject_id = $_POST['subject_id'];

    $stmt = $conn->prepare("UPDATE jegy SET ertek = ?, datum = ?, tipus = ?, targyid = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $value, $date, $type, $subject_id, $grade_id);
    
    if ($stmt->execute()) {
        echo "Jegy módosítva!";
    } else {
        echo "Hiba a módosítás során: " . $stmt->error;
    }
}

// Jegy ID lekérdezése
$grade_id = $_GET['id'];
$query = "SELECT * FROM jegy WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $grade_id);
$stmt->execute();
$result = $stmt->get_result();
$grade = $result->fetch_assoc();
?>


<div class="container">
    <h1>Jegy Módosítása</h1>
    <form method="POST" action="">
        <input type="hidden" name="grade_id" value="<?php echo $grade['id']; ?>">
        
        <label for="value">Érték:</label>
        <input type="text" name="value" value="<?php echo $grade['ertek']; ?>" required>
        
        <label for="date">Dátum:</label>
        <input type="date" name="date" value="<?php echo $grade['datum']; ?>" required>
        
        <label for="type">Típus:</label>
        <input type="text" name="type" value="<?php echo $grade['tipus']; ?>" required>
        
        <label for="subject_id">Tárgy ID:</label>
        <input type="number" name="subject_id" value="<?php echo $grade['targyid']; ?>" required>
        
        <button type="submit">Módosítás</button>
        <a href="../tanar/tgrade_list.php" class="btn btn-outline-dark">Mégse</a>
    </form>
</div>

