<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];

    $stmt = $conn->prepare("INSERT INTO diak (nev) VALUES (?)");
    $stmt->bind_param("s", $student_name);
    
    if ($stmt->execute()) {
        echo "Diák hozzáadva!";
        header("Location: student_list.php");
        exit();
    } else {
        echo "Hiba a hozzáadás során: " . $stmt->error;
    }
}
?>


<div class="container">
    <h1>Diák Hozzáadása</h1>
    <form method="POST" action="">
        <label for="student_name">Diák neve:</label>
        <input type="text" name="student_name" required>
        <button type="submit">Hozzáadás</button>
    </form>
</div>

