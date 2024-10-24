<?php
session_start();
include '../includes/db.php';
include '../includes/diakheader.php';

// Diákok listázása
$query = "SELECT * FROM diak";
$result = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $gender = isset($_POST['gender']) ? 1 : 0; // 1 = fiú, 0 = lány

    $insertQuery = "INSERT INTO diak (nev, osztaly, fiu) VALUES ('$name', '$class', '$gender')";
    if ($conn->query($insertQuery) === TRUE) {
        $success = "Diák hozzáadva!";
    } else {
        $error = "Hiba: " . $conn->error;
    }
}
?>
 <div class="container">

<h2>Diákok listája</h2>
<table>
    <thead>
        <tr>
            <th>Név</th>
            <th>Osztály</th>
            <th>Fiú</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['nev']; ?></td>
            <td><?php echo $row['osztaly']; ?></td>
            <td><?php echo $row['fiu'] ? 'Igen' : 'Nem'; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
        </div>
<?php include '../includes/footer.php'; ?>
