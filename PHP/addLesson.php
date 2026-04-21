<?php
// =========================================
// DEBUGGING (SHOW ERRORS DURING DEV)
// =========================================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connection
include 'db.php';

// =========================================
// GET FORM DATA
// =========================================
$student  = $_POST['studentIndex'] ?? null;
$tutor    = $_POST['tutorIndex'] ?? null;
$location = $_POST['locationIndex'] ?? null;

// Course OR Topic (mutually exclusive)
$course = (isset($_POST['courseIndex']) && $_POST['courseIndex'] !== "")
    ? $_POST['courseIndex']
    : null;

$topic = (isset($_POST['topic']) && trim($_POST['topic']) !== "")
    ? trim($_POST['topic'])
    : null;

// Schedule data
$date     = $_POST['lessonDate'] ?? null;
$start    = $_POST['startTime'] ?? null;
$duration = $_POST['duration'] ?? null;

// =========================================
// VALIDATION RULES
// =========================================

// Required fields
if (!$student || !$tutor || !$location) {
    header("Location: /TUTORLINK/Lessons/AddLesson.php?error=Missing required fields");
    exit();
}

// Must provide course OR topic
if ($course === null && $topic === null) {
    header("Location: /TUTORLINK/Lessons/AddLesson.php?error=Provide course OR topic");
    exit();
}

// Cannot provide both
if ($course !== null && $topic !== null) {
    header("Location: /TUTORLINK/Lessons/AddLesson.php?error=Cannot provide both course and topic");
    exit();
}

// Default duration if user leaves blank
if (!$duration) {
    $duration = 30;
}

// Validate duration
if ($duration <= 0) {
    header("Location: /TUTORLINK/Lessons/AddLesson.php?error=Invalid duration");
    exit();
}

// =========================================
// TIME CALCULATION
// =========================================
// Compute end time from start + duration
$end = date("H:i:s", strtotime("+$duration minutes", strtotime($start)));

// =========================================
// CONFLICT CHECK (TUTOR DOUBLE-BOOKING)
// =========================================
$conflictSQL = "
SELECT * FROM Lessons
WHERE TutorIndex = $tutor
AND LessonDate = '$date'
AND (StartTime < '$end' AND EndTime > '$start')
";

$result = $conn->query($conflictSQL);

// If conflict found → reject booking
if ($result->num_rows > 0) {
    header("Location: /TUTORLINK/Lessons/AddLesson.php?error=Tutor already booked at this time");
    exit();
}

// =========================================
// GENERATE UNIQUE LESSON ID
// =========================================
$res = $conn->query("SELECT MAX(LessonID) AS maxID FROM Lessons");
$row = $res->fetch_assoc();
$newID = ($row['maxID'] ?? 0) + 1;

// =========================================
// PREPARE SQL VALUES
// =========================================
$courseSQL = $course === null ? "NULL" : $course;
$topicSQL  = $topic === null ? "NULL" : "'" . $conn->real_escape_string($topic) . "'";

$status = "Upcoming";

// =========================================
// INSERT LESSON
// =========================================
$sql = "INSERT INTO Lessons 
(LessonID, StudentIndex, TutorIndex, LocationIndex, CourseIndex, Topic, LessonDate, StartTime, EndTime, Duration, Status)
VALUES 
($newID, $student, $tutor, $location, $courseSQL, $topicSQL, '$date', '$start', '$end', $duration, '$status')";

// Execute query
if ($conn->query($sql)) {
    header("Location: /TUTORLINK/Lessons/ViewLessons.php?success=Lesson booked");
} else {
    $error = urlencode($conn->error);
    header("Location: /TUTORLINK/Lessons/AddLesson.php?error=$error");
}
exit();
?>