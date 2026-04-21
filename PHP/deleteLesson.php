<?php
// =========================================
// DATABASE CONNECTION
// =========================================
include 'db.php';

// =========================================
// GET LESSON ID FROM URL
// =========================================
$id = $_GET['id'];

// =========================================
// DELETE LESSON
// =========================================
// Assumes LessonID is valid and exists
$conn->query("DELETE FROM Lessons WHERE LessonID = $id");

// =========================================
// REDIRECT WITH SUCCESS MESSAGE
// =========================================
header("Location: /TUTORLINK/Lessons/ViewLessons.php?success=Lesson deleted successfully");
exit();
?>