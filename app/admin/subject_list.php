<?php
session_start();
// Adatbázis kapcsolat
include '../includes/db.php';
include '../includes/header.php';

// Tárgyak lekérdezése az adatbázisból
$query = "SELECT * FROM targy";
$result = $conn->query($query);
?>

<div class="container">
    <h1>Tárgyak listája</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Kategória</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nev']; ?></td>
                    <td><?php echo $row['kategoria']; ?></td>
                    <td>
                        <!-- Módosítás gomb, ahol az id átadásra kerül -->
                        <a href="../admin/edit_subject.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-success">Módosítás</a>
                        <a href="../admin/delete_subject.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger">Törlés</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
