<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Tantárgyak listázása
$query = "SELECT * FROM targy";
$result = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_subject'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];

    $insertQuery = "INSERT INTO targy (nev, kategoria) VALUES ('$name', '$category')";
    if ($conn->query($insertQuery) === TRUE) {
        $success = "Tantárgy hozzáadva!";
    } else {
        $error = "Hiba: " . $conn->error;
    }
}
?>

<h1>Tantárgyak kezelése</h1>

<?php if (isset($success)) echo "<p>$success</p>"; ?>
<?php if (isset($error)) echo "<p>$error</p>"; ?>

<form method="POST" action="">
    <label for="name">Tantárgy Név:</label>
    <input type="text" name="name" required>
    <label for="category">Kategória:</label>
    <input type="text" name="category" required>
    <button type="submit" name="add_subject">Tantárgy hozzáadása</button>
</form>

<h2>Tantárgyak listája</h2>
<table>
    <thead>
        <tr>
            <th>Név</th>
            <th>Kategória</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['nev']; ?></td>
            <td><?php echo $row['kategoria']; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
