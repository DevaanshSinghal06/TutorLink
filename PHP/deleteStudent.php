<?php
include 'db.php';

$id = $_GET['id'];

// If using CASCADE → this is enough
$conn->query("DELETE FROM Students WHERE StudentIndex = $id");

// Redirect WITH success message
header("Location: /TUTORLINK/Students/ViewStudents.php?success=Student deleted successfully");
exit();
?>