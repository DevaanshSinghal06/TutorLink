<?php
include 'db.php';

$id = $_GET['id'];

$conn->query("DELETE FROM Lessons WHERE LessonID = $id");

header("Location: /TUTORLINK/Lessons/ViewLessons.php?success=Lesson deleted successfully");
exit();
?>