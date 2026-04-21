<?php
include 'db.php';

// =========================================
// GET FORM DATA
// =========================================
$id = $_POST['id'];

$firstName = $_POST['firstName'];
$surname   = $_POST['surname'];
$age       = $_POST['age'];
$phone     = $_POST['phone'];
$email     = $_POST['email'];
$type      = $_POST['tutorType'];

// =========================================
// HANDLE NULL VALUES
// =========================================
$phone = empty($phone) ? "NULL" : "'$phone'";
$email = empty($email) ? "NULL" : "'$email'";

// =========================================
// UPDATE TUTOR CORE INFO
// =========================================
$sql = "UPDATE Tutors SET
FirstName='$firstName',
Surname='$surname',
Age=$age,
PhoneNumber=$phone,
Email=$email,
TutorType='$type'
WHERE TutorIndex=$id";

$conn->query($sql);

// =========================================
// UPDATE COURSE SPECIALIZATIONS
// =========================================

// Step 1: Remove ALL existing mappings
$conn->query("DELETE FROM TutorCourses WHERE TutorIndex = $id");

// Step 2: Insert newly selected courses
if (isset($_POST['courses'])) {
    foreach ($_POST['courses'] as $courseID) {
        $conn->query("
            INSERT INTO TutorCourses (TutorIndex, CourseIndex)
            VALUES ($id, $courseID)
        ");
    }
}

// =========================================
// REDIRECT
// =========================================
header("Location: /TUTORLINK/Tutors/ViewTutor.php?success=Tutor updated successfully");
exit();
?>