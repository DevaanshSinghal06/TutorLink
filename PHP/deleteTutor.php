<?php
include 'db.php';

$id = $_GET['id'];

$conn->query("DELETE FROM Tutors WHERE TutorIndex = $id");

header("Location: /TUTORLINK/Tutors/ViewTutor.php?success=Tutor deleted successfully");
exit();
?>