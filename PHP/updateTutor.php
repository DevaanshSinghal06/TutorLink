<?php
include 'db.php';

$id = $_POST['id'];

$firstName = $_POST['firstName'];
$surname   = $_POST['surname'];
$age       = $_POST['age'];
$phone     = $_POST['phone'];
$email     = $_POST['email'];
$type      = $_POST['tutorType'];

$netid   = $_POST['netid'] ?: "NULL";
$cometid = $_POST['cometid'] ?: "NULL";
$tutorid = $_POST['tutorid'] ?: "NULL";
$company = $_POST['company'] ?: "NULL";
$other   = $_POST['other'] ?: "NULL";

// Wrap strings properly
$netid   = $netid === "NULL" ? "NULL" : "'$netid'";
$cometid = $cometid === "NULL" ? "NULL" : "'$cometid'";
$tutorid = $tutorid === "NULL" ? "NULL" : "'$tutorid'";
$company = $company === "NULL" ? "NULL" : "'$company'";
$other   = $other === "NULL" ? "NULL" : "'$other'";
$phone   = empty($phone) ? "NULL" : "'$phone'";
$email   = empty($email) ? "NULL" : "'$email'";

$sql = "UPDATE Tutors SET
FirstName='$firstName',
Surname='$surname',
Age=$age,
PhoneNumber=$phone,
Email=$email,
TutorType='$type',
NetID=$netid,
CometID=$cometid,
TutorID=$tutorid,
Company=$company,
Other=$other
WHERE TutorIndex=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: /TUTORLINK/Tutors/ViewTutor.php?success=Tutor updated successfully");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>