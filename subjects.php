<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

$query = "SELECT * FROM targy";
$result = $conn->query($query);
?>

<h1>Tantárgyak</h1>
<table>
    <thead>
        <tr>
            <th>Tantárgy Név</th>
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
