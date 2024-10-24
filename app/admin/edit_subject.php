<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/adminheader.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_id = $_POST['subject_id'];
    $subject_name = $_POST['subject_name'];
    $subject_category = $_POST['subject_category'];

    $stmt = $conn->prepare("UPDATE targy SET nev = ? WHERE id = ?");
    $stmt->bind_param("si", $subject_name, $subject_id, $subject_category);
    
    if ($stmt->execute()) {
        echo "Tárgy módosítva!";
    } else {
        echo "Hiba a módosítás során: " . $stmt->error;
    }
}

// Tárgy ID lekérdezése
$subject_id = $_GET['id'];
$query = "SELECT * FROM targy WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $subject_id);
$stmt->execute();
$result = $stmt->get_result();
$subject = $result->fetch_assoc();
?>


<div class="container">
    <h1>Tárgy Módosítása</h1>
    <form method="POST" action="">
        <input type="hidden" name="subject_id" value="<?php echo $subject['id']; ?>">
        
        <label for="subject_name">Tárgy neve:</label>
        <input type="text" name="subject_name" value="<?php echo $subject['nev']; ?>" required>

        <label for="subject_category">Tárgy kategoria:</label>
        <input type="text" name="subject_category" value="<?php echo $subject['kategoria']; ?>" required>
        
        <button type="submit">Módosítás</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>