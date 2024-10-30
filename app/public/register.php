<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role = "látogató"; // Alapértelmezett jogosultság

    $query = "INSERT INTO felhasznalo (nev, felhasznalo_nev, jelszo, jogosultsag) VALUES ('$name', '$username', '$password', '$role')";
    if ($conn->query($query) === TRUE) {
        header('Location: index.php');
    } else {
        $error = "Regisztrációs hiba: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>Regisztráció</title>
</head>
<body>
<h1>Regisztráció</h1>
<?php if (isset($error)) echo "<p>$error</p>"; ?>
<form method="POST" action="">
    <label for="name">Név:</label>
    <input type="text" name="name" required>
    <label for="username">Felhasználónév:</label>
    <input type="text" name="username" required>
    <label for="password">Jelszó:</label>
    <input type="password" name="password" required>
    <button type="submit">Regisztráció</button>
</form>
</body>
</html>
