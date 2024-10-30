<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Osztályok lekérdezése az adatbázisból a legördülő listához
$classQuery = "SELECT DISTINCT(osztaly) FROM diak ORDER BY osztaly";
$classResult = $conn->query($classQuery);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];
    $class = $_POST['class'];
    $is_boy = $_POST['is_boy'] === 'true' ? 1 : 0; // Igaz vagy hamis érték

    $stmt = $conn->prepare("INSERT INTO diak (nev, osztaly, fiu) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $student_name, $class, $is_boy);

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
        
        <label for="class">Osztály:</label>
        <select name="class" required>
            <option value="">Válassz osztályt</option>
            <?php while ($row = $classResult->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['osztaly']); ?>">
                    <?php echo htmlspecialchars($row['osztaly']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <label for="is_boy">Nem:</label>
        <select name="is_boy" required>
            <option value="">Válassz nemet</option>
            <option value="true">Fiu</option>
            <option value="false">Lány</option>
        </select>
        
        <button type="submit">Hozzáadás</button>
    </form>
</div>
