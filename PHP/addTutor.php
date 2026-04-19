<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_OFF);

include 'db.php';

// =========================
// GET FORM DATA (SAFE)
// =========================
$firstName = $_POST['firstName'] ?? '';
$surname   = $_POST['surname'] ?? '';
$age       = $_POST['age'] ?? 0;
$phone     = $_POST['phone'] ?? null;
$email     = $_POST['email'] ?? null;
$tutorType = $_POST['tutorType'] ?? '';

$netid   = $_POST['netid'] ?? null;
$cometid = $_POST['cometid'] ?? null;
$tutorid = $_POST['tutorid'] ?? null;
$company = $_POST['company'] ?? null;
$other   = $_POST['other'] ?? null;

$courses = $_POST['courses'] ?? [];

// =========================
// VALIDATION
// =========================
if (empty($courses)) {
    header("Location: /TUTORLINK/Tutors/AddTutorStep1.html?error=Select at least one course");
    exit();
}

if (empty($tutorType)) {
    header("Location: /TUTORLINK/Tutors/AddTutorStep1.html?error=Tutor type missing");
    exit();
}

// =========================
// GENERATE TutorIndex (SAFE)
// =========================
$result = $conn->query("SELECT MAX(TutorIndex) AS maxID FROM Tutors");
$row = $result->fetch_assoc();
$newID = ($row['maxID'] ?? 0) + 1;

// =========================
// HANDLE NULL VALUES
// =========================
$netid   = empty($netid)   ? "NULL" : "'$netid'";
$cometid = empty($cometid) ? "NULL" : "'$cometid'";
$tutorid = empty($tutorid) ? "NULL" : "'$tutorid'";
$company = empty($company) ? "NULL" : "'$company'";
$other   = empty($other)   ? "NULL" : "'$other'";
$phone   = empty($phone)   ? "NULL" : "'$phone'";
$email   = empty($email)   ? "NULL" : "'$email'";

// =========================
// INSERT INTO Tutors
// =========================
$sql = "INSERT INTO Tutors 
(TutorIndex, FirstName, Surname, Age, PhoneNumber, Email, TutorType, NetID, CometID, TutorID, Company, Other)
VALUES 
($newID, '$firstName', '$surname', $age, $phone, $email, '$tutorType', $netid, $cometid, $tutorid, $company, $other)";

if ($conn->query($sql) === TRUE) {

    // =========================
    // INSERT SPECIALIZATIONS
    // =========================
    foreach ($courses as $course) {
        $conn->query("INSERT INTO TutorSpecializations (TutorIndex, CourseIndex)
                      VALUES ($newID, $course)");
    }

    // =========================
    // REDIRECT TO VIEW TUTOR
    // =========================
    header("Location: /TUTORLINK/Tutors/ViewTutor.php?success=Tutor added successfully");
    exit();

} else {
    echo "SQL ERROR: " . $conn->error;
    exit();
}
?>