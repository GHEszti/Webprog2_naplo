<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

$query = "SELECT * FROM diak";
$result = $conn->query($query);
?>

<h1>Diákok</h1>
<table>
    <thead>
        <tr>
            <th>Diák Név</th>
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

<?php include '../includes/footer.php'; ?>
