<?php
session_start();
// Adatbázis kapcsolat
include '../includes/db.php';
include '../includes/header.php';

// Jegy hozzáadása
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_grade'])) {
    $studentId = $_POST['student_id'];
    $subjectId = $_POST['subject_id'];
    $value = $_POST['value'];
    $type = $_POST['type'];

    $insertQuery = "INSERT INTO jegy (diakid, targyid, ertek, tipus) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iiis", $studentId, $subjectId, $value, $type);

    if ($stmt->execute()) {
        $success = "Jegy hozzáadva!";
    } else {
        $error = "Hiba: " . $stmt->error;
    }
}

// Jegyek lekérdezése JOIN-nal a diak és targy táblákból
$query = "
    SELECT jegy.id, jegy.ertek, jegy.datum, jegy.tipus, diak.nev AS diak_nev, targy.nev AS targy_nev
    FROM jegy
    JOIN diak ON jegy.diakid = diak.id
    JOIN targy ON jegy.targyid = targy.id
";
$result = $conn->query($query);

// Diákok és tantárgyak lekérdezése a legördülő listákhoz
$studentsQuery = "SELECT * FROM diak";
$studentsResult = $conn->query($studentsQuery);

$subjectsQuery = "SELECT * FROM targy";
$subjectsResult = $conn->query($subjectsQuery);
?>

<div class="container">
    <h1>Jegyek listája</h1>
    <table id="gradesTable" class="display">
        <thead>
            <tr>
                <th>Diák neve</th>
                <th>Tantárgy neve</th>
                <th>Érték</th>
                <th>Dátum</th>
                <th>Típus</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['diak_nev']); ?></td>
                    <td><?php echo htmlspecialchars($row['targy_nev']); ?></td>
                    <td><?php echo htmlspecialchars($row['ertek']); ?></td>
                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($row['datum']))); ?></td>
                    <td><?php echo htmlspecialchars($row['tipus']); ?></td>
                    <td>
                        <a href="../admin/edit_grade.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-success mb-2">Módosítás</a>
                        <a href="../admin/deletegrade.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger">Törlés</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#gradesTable').DataTable({
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
<?php include '../includes/footer.php'; ?>
