<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/header.php';

// Jegy ID lekérdezése
$grade_id = $_GET['id'];
$query = "
    SELECT jegy.*, diak.nev AS diak_nev, targy.nev AS targy_nev 
    FROM jegy 
    JOIN diak ON jegy.diakid = diak.id 
    JOIN targy ON jegy.targyid = targy.id 
    WHERE jegy.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $grade_id);
$stmt->execute();
$result = $stmt->get_result();
$grade = $result->fetch_assoc();

// Jegy módosítása
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $grade_id = $_POST['grade_id'];
    $value = $_POST['value'];
    $date = $_POST['date'];
    $type = $_POST['type'];
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];

    $stmt = $conn->prepare("UPDATE jegy SET ertek = ?, datum = ?, tipus = ?, diakid = ?, targyid = ? WHERE id = ?");
    $stmt->bind_param("sssiii", $value, $date, $type, $student_id, $subject_id, $grade_id);
    
    if ($stmt->execute()) {
        echo "Jegy módosítva!";
    } else {
        echo "Hiba a módosítás során: " . $stmt->error;
    }
}

// Diákok és tárgyak lekérdezése a legördülő listákhoz
$studentsQuery = "SELECT id, nev FROM diak";
$studentsResult = $conn->query($studentsQuery);

$subjectsQuery = "SELECT id, nev FROM targy";
$subjectsResult = $conn->query($subjectsQuery);
?>

<div class="container">
    <h1>Jegy Módosítása</h1>
    <form method="POST" action="">
        <input type="hidden" name="grade_id" value="<?php echo $grade['id']; ?>">
        
        <label for="value">Érték:</label>
        <input type="text" name="value" value="<?php echo htmlspecialchars($grade['ertek']); ?>" required>
        
        <label for="date">Dátum:</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($grade['datum']); ?>" required>
        
        <label for="type">Típus:</label>
        <input type="text" name="type" value="<?php echo htmlspecialchars($grade['tipus']); ?>" required>
        
        <label for="student_id">Diák:</label>
        <select name="student_id" required>
            <?php while ($student = $studentsResult->fetch_assoc()): ?>
                <option value="<?php echo $student['id']; ?>" <?php if ($student['id'] == $grade['diakid']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($student['nev']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <label for="subject_id">Tantárgy:</label>
        <select name="subject_id" required>
            <?php while ($subject = $subjectsResult->fetch_assoc()): ?>
                <option value="<?php echo $subject['id']; ?>" <?php if ($subject['id'] == $grade['targyid']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($subject['nev']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <button type="submit">Módosítás</button>
        <a href="../admin/grade_list.php" class="btn btn-outline-dark">Mégse</a>
    </form>
</div>

