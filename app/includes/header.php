<?php

include '../includes/db.php';

// Menüpontok lekérdezése az adatbázisból
function getMenuItems($conn, $user_name = null) {
    if ($user_name) {
        // Ha van felhasználói név, akkor szűrjük a menüpontokat
        $stmt = $conn->prepare("SELECT nev, url FROM menu WHERE szerepkor IS NULL OR szerepkor = ? ORDER BY sorrend");
        $stmt->bind_param("s", $user_name);
    } else {
        // Ha nincs bejelentkezve, akkor csak azokat a menüpontokat mutatjuk, amelyek mindenki számára elérhetőek
        $stmt = $conn->prepare("SELECT nev, url FROM menu WHERE szerepkor IS NULL ORDER BY sorrend");
    }
    
    $stmt->execute();
    return $stmt->get_result();
}

// Session-ből betöltjük a felhasználó nevét
$user_name = isset($_SESSION['felhasznalo_nev']) ? $_SESSION['felhasznalo_nev'] : null;

// Menüpontok lekérdezése
$menu_items = getMenuItems($conn, $user_name);
?>

</style>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Iskolai Napló</title>
    <base href="/app/public/">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/scripts.js" defer></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

</head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../public/index.php"><img src="../public/images/school-bag.png" class="header-logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php while ($row = $menu_items->fetch_assoc()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $row['url']; ?>"><?php echo $row['nev']; ?></a>
                    </li>
                <?php endwhile; ?>
                <?php if (isset($_SESSION['felhasznalo_nev'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../public/logout.php">Kijelentkezés</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
    </header>
</body>
</html>