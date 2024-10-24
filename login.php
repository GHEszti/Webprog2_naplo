<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Jelszó titkosítása
    $query = "SELECT * FROM felhasznalo WHERE felhasznalo_nev='$username' AND jelszo='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $username;
        header('Location: index.php');
    } else {
        $error = "Hibás felhasználónév vagy jelszó!";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>Bejelentkezés</title>
</head>
<body>
<h1>Bejelentkezés</h1>
<?php if (isset($error)) echo "<p>$error</p>"; ?>
<form method="POST" action="">
    <label for="username">Felhasználónév:</label>
    <input type="text" name="username" required>
    <label for="password">Jelszó:</label>
    <input type="password" name="password" required>
    <button type="submit">Bejelentkezés</button>
</form>
</body>
</html>
