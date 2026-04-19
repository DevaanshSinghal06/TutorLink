<?php
$host = "localhost";
$user = "root";
$password = "root"; // MAMP default
$database = "TutorLink"; // MUST match your database name EXACTLY

$conn = new mysqli($host, $user, $password, $database, 8889);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>