<?php
session_start();
include '../includes/db.php';
include '../includes/adminheader.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_name = $_POST['subject_name'];

    $stmt = $conn->prepare("INSERT INTO targy (nev) VALUES (?)");
    $stmt->bind_param("s", $subject_name);
    
    if ($stmt->execute()) {
        echo "Tárgy hozzáadva!";
        header("Location: subject_list.php");
        exit();
    } else {
        echo "Hiba a hozzáadás során: " . $stmt->error;
    }
}
?>


<div class="container">
    <h1>Tárgy Hozzáadása</h1>
    <form method="POST" action="">
        <label for="subject_name">Tárgy neve:</label>
        <input type="text" name="subject_name" required>
        <button type="submit">Hozzáadás</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
