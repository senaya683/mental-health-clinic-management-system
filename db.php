<?php
$host = "localhost";
$port = "5432";
$dbname = "final_db";
$user = "postgres"; // Change if needed
$password = "SENAYA58";

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>