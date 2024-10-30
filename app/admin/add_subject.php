<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Kategóriák lekérdezése az adatbázisból
$categoriesQuery = "SELECT DISTINCT kategoria FROM targy WHERE kategoria IS NOT NULL";
$categoriesResult = $conn->query($categoriesQuery);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_name = $_POST['subject_name'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("INSERT INTO targy (nev, kategoria) VALUES (?, ?)");
    $stmt->bind_param("ss", $subject_name, $category);
    
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

        <label for="category">Kategória:</label>
        <select name="category" required>
            <option value="">Válassz egy kategóriát</option>
            <?php while ($row = $categoriesResult->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['kategoria']); ?>">
                    <?php echo htmlspecialchars($row['kategoria']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        
        <button type="submit">Hozzáadás</button>
    </form>
</div>
