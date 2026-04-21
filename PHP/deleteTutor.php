<?php
// =========================================
// DB CONNECTION
// =========================================
include 'db.php';

// =========================================
// GET TUTOR ID
// =========================================
$id = $_GET['id'];

// =========================================
// DELETE TUTOR
// =========================================
// NOTE: Assumes relational cleanup (cascade or manual)
$conn->query("DELETE FROM Tutors WHERE TutorIndex = $id");

// =========================================
// REDIRECT
// =========================================
header("Location: /TUTORLINK/Tutors/ViewTutor.php?success=Tutor deleted successfully");
exit();
?>