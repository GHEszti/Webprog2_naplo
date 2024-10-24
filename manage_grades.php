<?php
session_start();
include '../includes/db.php';
include '../includes/adminheader.php';

// Jegyek listázása
$query = "SELECT jegy.*, diak.nev AS diak_nev, targy.nev AS targy_nev 
          FROM jegy 
          JOIN diak ON jegy.diakid = diak.id 
          JOIN targy ON jegy.targyid = targy.id";
$result = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_grade'])) {
    $studentId = $_POST['student_id'];
    $subjectId = $_POST['subject_id'];
    $value = $_POST['value'];
    $type = $_POST['type'];

    $insertQuery = "INSERT INTO jegy (diakid, targyid, ertek, tipus) VALUES ('$studentId', '$subjectId', '$value', '$type')";
    if ($conn->query($insertQuery) === TRUE) {
        $success = "Jegy hozzáadva!";
    } else {
        $error = "Hiba: " . $conn->error;
    }
}

// Diákok és tantárgyak lekérdezése a legördülő listákhoz
$studentsQuery = "SELECT * FROM diak";
$studentsResult = $conn->query($studentsQuery);

$subjectsQuery = "SELECT * FROM targy";
$subjectsResult = $conn->query($subjectsQuery);
?>
 <div class="container">

<h2>Jegyek listája</h2>
<table>
    <thead>
        <tr>
            <th>Diák Név</th>
            <th>Tantárgy</th>
            <th>Érték</th>
            <th>Típus</th>
            <th>Dátum</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['diak_nev']; ?></td>
            <td><?php echo $row['targy_nev']; ?></td>
            <td><?php echo $row['ertek']; ?></td>
            <td><?php echo $row['tipus']; ?></td>
            <td><?php echo date('Y-m-d', strtotime($row['datum'])); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
        </div>
<?php include '../includes/footer.php'; ?>
