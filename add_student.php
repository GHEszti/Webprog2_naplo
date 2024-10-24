<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];

    $stmt = $conn->prepare("INSERT INTO diak (nev) VALUES (?)");
    $stmt->bind_param("s", $student_name);
    
    if ($stmt->execute()) {
        echo "Diák hozzáadva!";
    } else {
        echo "Hiba a hozzáadás során: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Diák Hozzáadása</title>
</head>
<body>
    <h1>Diák Hozzáadása</h1>
    <form method="POST" action="">
        <label for="student_name">Diák neve:</label>
        <input type="text" name="student_name" required>
        <button type="submit">Hozzáadás</button>
    </form>
</body>
</html>
