<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/adminheader.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $student_osztaly = $_POST['student_osztaly'];
    
    $stmt = $conn->prepare("UPDATE diak SET nev = ?, osztaly =? WHERE id = ?");
    $stmt->bind_param("si", $student_name, $student_id, $student_osztaly);
    
    if ($stmt->execute()) {
        echo "Diák módosítva!";
    } else {
        echo "Hiba a módosítás során: " . $stmt->error;
    }
}

// Diák ID lekérdezése
$student_id = $_GET['id'];
$query = "SELECT * FROM diak WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>


<div class="container">
    <h1>Diák Módosítása</h1>
    <form method="POST" action="">
        <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
        
        <label for="student_name">Diák neve:</label>
        <input type="text" name="student_name" value="<?php echo $student['nev']; ?>" required>
        <label for="student_name">Osztály:</label>
        <input type="text" name="student_name" value="<?php echo $student['osztaly']; ?>" required>

        <button type="submit">Módosítás</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
