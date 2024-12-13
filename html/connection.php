<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'clinic';
// set DSN 
$dsn = "mysql:host=$host;dbname=$dbname";
// create a new PDO instance
try {
    $pdo = new PDO($dsn, $user, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
