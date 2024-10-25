<?php
session_start();
// Adatbázis kapcsolat
include '../includes/db.php';
include '../includes/header.php';

// Diákok lekérdezése az adatbázisból
$query = "SELECT * FROM diak";
$result = $conn->query($query);
?>

<div class="container">
    <h1>Diákok listája</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Osztály</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nev']; ?></td>
                    <td><?php echo $row['osztaly']; ?></td>
                    <td>
                        <!-- Módosítás gomb, ahol az id átadásra kerül -->
                        <a href="../admin/edit_student.php?id=<?php echo $row['id']; ?>"class="btn btn-outline-success">Módosítás</a>
                        <a href="../admin/delete_student.php?id=<?php echo $row['id']; ?>"class="btn btn-outline-danger">Törlés</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
