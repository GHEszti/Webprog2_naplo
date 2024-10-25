<?php
include 'db.php'; // Kapcsolódás az adatbázishoz

function buildMenu($parent_id = null) {
    global $conn;

    // Lekérdezzük az aktuális szinthez tartozó menüpontokat
    $stmt = $conn->prepare("SELECT id, nev, url FROM menu WHERE parent_id IS NULL OR parent_id = ? ORDER BY sorrend");
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Ellenőrizzük, van-e gyerek elem
    if ($result->num_rows > 0) {
        echo '<ul>';
        while ($row = $result->fetch_assoc()) {
            echo '<li>';
            echo '<a href="' . $row['url'] . '">' . $row['nev'] . '</a>';

            // Gyerek elemek keresése
            buildMenu($row['id']); 
            echo '</li>';
        }
        echo '</ul>';
    }
}
?>
