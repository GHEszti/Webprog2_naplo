<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

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

<h1>Jegyek kezelése</h1>

<?php if (isset($success)) echo "<p>$success</p>"; ?>
<?php if (isset($error)) echo "<p>$error</p>"; ?>

<form method="POST" action="">
    <label for="student_id">Diák:</label>
    <select name="student_id" required>
        <?php while ($row = $studentsResult->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['nev']; ?></option>
        <?php endwhile; ?>
    </select>

    <label for="subject_id">Tantárgy:</label>
    <select name="subject_id" required>
        <?php while ($row = $subjectsResult->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['nev']; ?></option>
        <?php endwhile; ?>
    </select>

    <label for="value">Érték:</label>
    <input type="number" name="value" min="1" max="5" required>

    <label for="type">Típus:</label>
    <input type="text" name="type" required>

    <button type="submit" name="add_grade">Jegy hozzáadása</button>
</form>

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

<?php include '../includes/footer.php'; ?>
