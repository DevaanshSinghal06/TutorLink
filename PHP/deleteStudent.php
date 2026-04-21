<?php
// =========================================
// DATABASE CONNECTION
// =========================================
include 'db.php';

// =========================================
// GET STUDENT ID
// =========================================
$id = $_GET['id'];

// =========================================
// DELETE STUDENT
// =========================================
// If foreign keys use CASCADE, related lessons will also be removed
$conn->query("DELETE FROM Students WHERE StudentIndex = $id");

// =========================================
// REDIRECT WITH SUCCESS MESSAGE
// =========================================
header("Location: /TUTORLINK/Students/ViewStudents.php?success=Student deleted successfully");
exit();
?>