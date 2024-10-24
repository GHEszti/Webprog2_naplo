<?php
session_start();
// Adatbázis kapcsolat
include '../includes/db.php';
include '../includes/tanarheader.php';

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
    <table>
        <thead>
            <tr>
                <th>Diák neve</th>
                <th>Tárgy neve</th>
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
                <a href="tanar/edit_grades.php?id=<?php echo $row['id']; ?>">Módosítás</a>
                <a href="tanar/delete_grades.php?id=<?php echo $row['id']; ?>">Törlés</a>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
