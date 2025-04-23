<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bashia_company";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
} 

// Set charset to utf8mb4 (best practice for supporting all characters)
$conn->set_charset("utf8mb4");
?>

