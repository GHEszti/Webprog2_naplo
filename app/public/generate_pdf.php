<?php
session_start();
include '../includes/db.php'; // Adatbázis kapcsolat
require_once('../TCPDF-main/tcpdf.php'); // TCPDF betöltése

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];

    // Diák ID lekérdezése a diák név alapján
    $stmt = $conn->prepare("SELECT id FROM diak WHERE nev = ?");
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
        $pdf->Cell(0, 10, 'Jegyek listája - ' . $student_name, 0, 1, 'C');

        // PDF tartalom
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(50, 10, 'Tárgy', 1);
        $pdf->Cell(30, 10, 'Érték', 1);
        $pdf->Cell(40, 10, 'Dátum', 1);
        $pdf->Ln();

        // Jegyek hozzáadása a PDF-hez
        while ($row = $grades->fetch_assoc()) {
            $pdf->Cell(50, 10, $row['tantargy'], 1);
            $pdf->Cell(30, 10, $row['ertek'], 1);
            $pdf->Cell(40, 10, $row['datum'], 1);
            $pdf->Ln();
        }

        // PDF letöltés
        $pdf->Output('jegyek_' . $student_name . '.pdf', 'D');
    } else {
        echo "Nincs ilyen diák!";
    }
}
?>
