<?php

$db = "mysql:host=localhost;dbname=guardsphere";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($db, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Uncomment for debugging: echo "Database connection successful.";

} catch (PDOException $er) {
    die("Connection Failed: " . $er->getMessage());
}
?>
