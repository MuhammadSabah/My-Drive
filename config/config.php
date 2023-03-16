<?php
$host = "localhost";
$dbname = "drive_manager";
$user = "root";
$pass = "";
$db = null;
try {
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br>";
}
