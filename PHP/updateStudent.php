<?php
// =========================================
// DB CONNECTION
// =========================================
include 'db.php';

// =========================================
// GET FORM DATA
// =========================================
$id = $_POST['id'];
$firstName = $_POST['firstName'];
$surname = $_POST['surname'];
$age = $_POST['age'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$gradyear = $_POST['gradyear'];

// =========================================
// UPDATE STUDENT RECORD
// =========================================
$sql = "UPDATE Students SET
FirstName='$firstName',
Surname='$surname',
Age='$age',
PhoneNumber='$phone',
Email='$email',
GradYear=$gradyear
WHERE StudentIndex=$id";

// =========================================
// EXECUTE + REDIRECT
// =========================================
if ($conn->query($sql) === TRUE) {
    header("Location: /TUTORLINK/Students/ViewStudents.php?success=Student updated successfully");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>