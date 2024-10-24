<?php
session_start();
include '../includes/db.php';
include '../includes/adminheader.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $date = $_POST['date'];
    $value = $_POST['value'];
    $type = $_POST['type'];
    $subject_id = $_POST['subject_id'];

    $stmt = $conn->prepare("INSERT INTO jegy (diakid, datum, ertek, tipus, targyid) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $student_id, $date, $value, $type, $subject_id);
    
    if ($stmt->execute()) {
        echo "Jegy hozzáadva!";
    } else {
        echo "Hiba a hozzáadás során: " . $stmt->error;
    }
}
?>

    <div class="container">

    
    <h1>Jegy Hozzáadása</h1>
    <form method="POST" action="">
        <label for="student_id">Diák ID:</label>
        <input type="number" name="student_id" required>
        
        <label for="date">Dátum:</label>
        <input type="date" name="date" required>
        
        <label for="value">Érték:</label>
        <input type="text" name="value" required>
        
        <label for="type">Típus:</label>
        <input type="text" name="type" required>
        
        <label for="subject_id">Tárgy ID:</label>
        <input type="number" name="subject_id" required>
        
        <button type="submit">Hozzáadás</button>
    </form>
    </div>
    <?php include '../includes/footer.php'; ?>
