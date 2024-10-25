<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Diákok lekérdezése az adatbázisból a legördülő listához
$studentsQuery = "SELECT id, nev FROM diak";
$studentsResult = $conn->query($studentsQuery);

// Tárgyak lekérdezése az adatbázisból a legördülő listához
$subjectsQuery = "SELECT id, nev FROM targy";
$subjectsResult = $conn->query($subjectsQuery);

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
        header("Location: grade_list.php");
        exit();
    } else {
        echo "Hiba a hozzáadás során: " . $stmt->error;
    }
}
?>

<div class="container">
    <h1>Jegy Hozzáadása</h1>
    <form method="POST" action="">
        <label for="student_id">Diák:</label>
        <select name="student_id" required>
            <option value="">Válassz egy diákot</option>
            <?php while ($row = $studentsResult->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nev']); ?></option>
            <?php endwhile; ?>
        </select>
        
        <label for="date">Dátum:</label>
        <input type="date" name="date" required>
        
        <label for="value">Érték:</label>
        <input type="text" name="value" required>
        
        <label for="type">Típus:</label>
        <input type="text" name="type" required>
        
        <label for="subject_id">Tárgy:</label>
        <select name="subject_id" required>
            <option value="">Válassz egy tantárgyat</option>
            <?php while ($row = $subjectsResult->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nev']); ?></option>
            <?php endwhile; ?>
        </select>
        
        <button type="submit">Hozzáadás</button>
    </form>
</div>
