<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
include '../includes/header.php';

// Felhasználói típus
$tipus = $_SESSION['felhasznalo_nev'];

require_once('../TCPDF-main/tcpdf.php'); // TCPDF betöltése

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['felhasznalo_nev'])) {
    header("Location: index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];

    // Diák ID lekérdezése a diák név alapján
    $stmt = $conn->prepare("SELECT id, nev FROM diak WHERE nev = ?");
    $stmt->bind_param("s", $student_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $student = $result->fetch_assoc();
        $student_id = $student['id'];

        // Jegyek lekérdezése a diák ID alapján
        $stmt = $conn->prepare("
            SELECT jegy.ertek, jegy.datum, targy.nev AS tantargy
            FROM jegy
            JOIN targy ON jegy.targyid = targy.id
            WHERE jegy.diakid = ?
        ");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $grades = $stmt->get_result();

        // TCPDF objektum létrehozása
        $pdf = new TCPDF();
        $pdf->AddPage();

        // PDF fejléc
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Jegyek listája - ' . $student['nev'], 0, 1, 'C');

        // PDF tartalom
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(50, 10, 'Tárgy', 1);
        $pdf->Cell(30, 10, 'Érték', 1);
        $pdf->Cell(40, 10, 'Dátum', 1);
        $pdf->Ln();

        // Jegyek hozzáadása a PDF-hez
        if ($grades->num_rows > 0) {
            while ($row = $grades->fetch_assoc()) {
                $pdf->Cell(50, 10, $row['tantargy'], 1);
                $pdf->Cell(30, 10, $row['ertek'], 1);
                $pdf->Cell(40, 10, $row['datum'], 1);
                $pdf->Ln();
            }
        } else {
            // Ha nincs jegy, ezt írja ki
            $pdf->Cell(0, 10, 'Nincs jegy a diákhoz!', 0, 1, 'C');
        }

        // PDF letöltés
        $pdf->Output('jegyek_' . $student['nev'] . '.pdf', 'D');
    } else {
        echo "Nincs ilyen diák!";
    }
}
?>


    <div class="container">
        <h1>Tanárok Dashboard</h1>

        <div class="dashboard">
            <div class="card col-4">
                <h2>Tárgyak kezelése</h2>
                <a href="../tanar/subjects.php" class="newb button">Tárgyak listázása</a>
            </div>

            <div class="card col-4">
                <h2>Diákok kezelése</h2>
                <a href="../tanar/students.php" class="newb button">Diákok listázása</a>
            </div>

            <div class="card col-4">
                <h2>Jegyek kezelése</h2>
                <a href="../tanar/add_grades.php" class="newb button">Új jegy hozzáadása</a>
                <a href="../tanar/tgrade_list.php" class="editb button">Jegy módosítása</a>
                <a href="../tanar/tgrade_list.php" class="deleteb button">Jegy törlése</a>
            </div>
        </div>
        <div class="row">
            <form method="POST" action="generate_pdf.php">
                <label for="student_name">Diák neve:</label>
                <input type="text" name="student_name" id="student_name" required>
                <button type="submit">PDF generálása</button>
            </form>
        </div>
    </div>


