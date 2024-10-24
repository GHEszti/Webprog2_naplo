<?php
// Például bejelentkezési függvény
function login($username, $password) {
    global $conn;
    $password = md5($password);
    $query = "SELECT * FROM felhasznalo WHERE felhasznalo_nev='$username' AND jelszo='$password'";
    return $conn->query($query);
}
``
