<?php
session_start();
// Minden session adat törlése
session_unset(); 

// Session teljes megsemmisítése
session_destroy(); 

// Visszairányítás a bejelentkezési oldalra
header("Location: login.php");
exit();
?>