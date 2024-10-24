<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/adminheader.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];

    $stmt = $conn->prepare("DELETE FROM diak WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    
    if ($stmt->execute()) {
        echo "Diák törölve!";
    } else {
        echo "Hiba a törlés során: " . $stmt->error;
    }
}

// Diák ID lekérdezése
$student_id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Diák Törlése</title>
</head>
<body>
<div class="container">
    <h1>Diák Törlése</h1>
    <p>Biztosan törölni szeretnéd a diákot?</p>
    <form method="POST" action="">
        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
        <button type="submit">Törlés</button>
    </form>
    <a href="list_students.php">Vissza a diákok listájához</a>
</div>
</body>
</html>
