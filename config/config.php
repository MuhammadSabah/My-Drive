<?php
$host = "localhost";
$dbname = "drive_manager";
$user = "root";
$pass = "";
$db;
try {
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br>";
}
