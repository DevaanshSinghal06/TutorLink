<?php
// =========================================
// DATABASE CONNECTION CONFIG
// =========================================
$host = "localhost";
$user = "root";
$password = "root";   // MAMP default
$database = "TutorLink"; // Must match DB name exactly

// Port 8889 used for MAMP MySQL
$conn = new mysqli($host, $user, $password, $database, 8889);

// =========================================
// CONNECTION CHECK
// =========================================
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>