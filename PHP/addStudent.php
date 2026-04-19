<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_OFF);

include 'db.php';

// Get form data
$firstName = $_POST['firstName'];
$surname = $_POST['surname'];
$age = $_POST['age'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$netid = $_POST['netid'];
$cometid = $_POST['cometid'];
$gradyear = $_POST['gradyear'];

// Generate StudentIndex automatically
$result = $conn->query("SELECT MAX(StudentIndex) AS maxID FROM Students");
$row = $result->fetch_assoc();
$newID = $row['maxID'] + 1;

// =========================
// BASIC VALIDATION
// =========================
if (empty($netid) && empty($cometid)) {
    header("Location: /TUTORLINK/Students/AddStudents.html?error=Provide NetID or CometID");
    exit();
}

if (empty($phone) && empty($email)) {
    header("Location: /TUTORLINK/Students/AddStudents.html?error=Provide Email or Phone");
    exit();
}

// =========================
// DUPLICATE CHECKS (NEW)
// =========================
$errors = [];

// Check NetID
if (!empty($netid)) {
    $check = $conn->query("SELECT 1 FROM Students WHERE NetID = '$netid'");
    if ($check->num_rows > 0) {
        $errors[] = "NetID already exists";
    }
}

// Check CometID
if (!empty($cometid)) {
    $check = $conn->query("SELECT 1 FROM Students WHERE CometID = '$cometid'");
    if ($check->num_rows > 0) {
        $errors[] = "Comet ID already exists";
    }
}

// Check Email (optional uniqueness)
if (!empty($email)) {
    $check = $conn->query("SELECT 1 FROM Students WHERE Email = '$email'");
    if ($check->num_rows > 0) {
        $errors[] = "Email already exists";
    }
}

// If ANY errors → send ALL back
if (!empty($errors)) {
    $errorString = implode(" | ", $errors);
    header("Location: /TUTORLINK/Students/AddStudents.html?error=" . urlencode($errorString));
    exit();
}

// =========================
// HANDLE EMPTY VALUES → NULL
// =========================
$netid = empty($netid) ? "NULL" : "'$netid'";
$cometid = empty($cometid) ? "NULL" : "'$cometid'";
$phone = empty($phone) ? "NULL" : "'$phone'";
$email = empty($email) ? "NULL" : "'$email'";
$gradyear = empty($gradyear) ? "NULL" : $gradyear;

// =========================
// INSERT QUERY
// =========================
$sql = "INSERT INTO Students 
(StudentIndex, FirstName, Surname, Age, PhoneNumber, Email, NetID, CometID, GradYear)
VALUES 
($newID, '$firstName', '$surname', $age, $phone, $email, $netid, $cometid, $gradyear)";

// =========================
// EXECUTE
// =========================
if ($conn->query($sql) === TRUE) {
    header("Location: /TUTORLINK/Dashboard.php?success=Student added successfully");
    exit();
} else {
    header("Location: /TUTORLINK/Students/AddStudents.html?error=Database error");
    exit();
}
?>