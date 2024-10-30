<?php
session_start();
// Adatbázis kapcsolat
include '../includes/db.php';
include '../includes/header.php';

// Tárgyak lekérdezése az adatbázisból
$query = "SELECT * FROM targy";
$result = $conn->query($query);

// Hibaellenőrzés a lekérdezés eredményére
if (!$result) {
    die("Hiba történt a tárgyak lekérdezése során: " . $conn->error);
}
?>

<div class="container">
    <h1>Tárgyak listája</h1>
    <table id="subjectsTable" class="display">
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
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['nev']); ?></td>
                    <td><?php echo htmlspecialchars($row['kategoria']); ?></td>
                    <td>
                        <a href="../admin/edit_subject.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-success">Módosítás</a>
                        <a href="../admin/delete_subject.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger">Törlés</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#subjectsTable').DataTable({
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
