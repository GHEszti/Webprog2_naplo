<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Diákok lekérdezése az adatbázisból
$query = "SELECT * FROM diak";
$result = $conn->query($query);
?>

<div class="container">
    <h1>Diákok listája</h1>
    <table id="studentTable" class="display">
        <thead>
            <tr>
                
                <th>Név</th>
                <th>Osztály</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    
                    <td><?php echo htmlspecialchars($row['nev']); ?></td>
                    <td><?php echo htmlspecialchars($row['osztaly']); ?></td>
                    <td>
                        <a href="../admin/edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-success">Módosítás</a>
                        <a href="../admin/delete_student.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger">Törlés</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#studentTable').DataTable({
            "language": {
                "search": "Keresés:",
                "lengthMenu": "Mutass _MENU_ bejegyzést",
                "info": "Megjelenítve _START_ - _END_ / _TOTAL_ bejegyzés",
                "paginate": {
                    "first": "Első",
                    "last": "Utolsó",
                    "next": "Következő",
                    "previous": "Előző"
                }
            }
        });
    });
</script>

<?php include '../includes/footer.php'; ?>
