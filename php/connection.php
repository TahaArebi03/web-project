<?php
$user = "root";
$pass = "";
$host = "localhost";
$db = "clinic";
$conn = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
