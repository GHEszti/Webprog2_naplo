<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/tanarheader.php';

// Ellenőrizzük, hogy az id létezik-e a GET paraméterben
if (!isset($_GET['id'])) {
    echo "Hiányzó jegy ID!";
    exit();
}

$grade_id = $_GET['id'];

// Lekérjük a törölni kívánt jegy adatait
$stmt = $conn->prepare("SELECT jegy.ertek, jegy.datum, diak.nev AS diak_nev, targy.nev AS targy_nev 
                        FROM jegy
                        INNER JOIN diak ON jegy.diakid = diak.id
                        INNER JOIN targy ON jegy.targyid = targy.id
                        WHERE jegy.id = ?");
$stmt->bind_param("i", $grade_id);
$stmt->execute();
$result = $stmt->get_result();
$grade = $result->fetch_assoc();

// Ha nem találunk ilyen jegyet
if (!$grade) {
    echo "A megadott ID-val nem található jegy.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Jegy törlése az adatbázisból
    $stmt = $conn->prepare("DELETE FROM jegy WHERE id = ?");
    $stmt->bind_param("i", $grade_id);

    if ($stmt->execute()) {
        echo "Jegy törölve!";
        header("Location: grade_list.php");
        exit();
    } else {
        echo "Hiba a törlés során: " . $stmt->error;
    }
}
?>

<div class="container">
    <h1>Jegy Törlése</h1>
    <p>Biztosan törölni szeretné a következő jegyet?</p>
    
    <!-- Törölni kívánt jegy adatai -->
    <p><strong>Diák neve:</strong> <?php echo htmlspecialchars($grade['diak_nev']); ?></p>
    <p><strong>Tárgy neve:</strong> <?php echo htmlspecialchars($grade['targy_nev']); ?></p>
    <p><strong>Jegy értéke:</strong> <?php echo htmlspecialchars($grade['ertek']); ?></p>
    <p><strong>Dátum:</strong> <?php echo htmlspecialchars($grade['datum']); ?></p>

    <form method="POST" action="">
        <button type="submit">Igen, törlés</button>
        <a href="tanar/tgrade_list.php">Mégse</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
