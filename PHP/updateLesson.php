<?php
include 'db.php';

// =========================================
// CASE 1: STATUS UPDATE (GET REQUEST)
// =========================================
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Get parameters
    $id = $_GET['id'] ?? null;
    $status = $_GET['status'] ?? null;

    // Validate inputs
    if (!$id || !$status) {
        header("Location: /TUTORLINK/Lessons/ViewLessons.php?error=Invalid request");
        exit();
    }

    // Only allow specific status changes
    $allowed = ["Cancelled", "No Show"];

    if (!in_array($status, $allowed)) {
        header("Location: /TUTORLINK/Lessons/ViewLessons.php?error=Invalid status");
        exit();
    }

    // Update lesson status
    $conn->query("UPDATE Lessons SET Status='$status' WHERE LessonID=$id");

    header("Location: /TUTORLINK/Lessons/ViewLessons.php?success=Lesson updated successfully");
    exit();
}


// =========================================
// CASE 2: RESCHEDULE LESSON (POST REQUEST)
// =========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $id       = $_POST['id'] ?? null;
    $date     = $_POST['lessonDate'] ?? null;
    $start    = $_POST['startTime'] ?? null;
    $duration = $_POST['duration'] ?? null;
    $location = $_POST['locationIndex'] ?? null;

    // =========================================
    // VALIDATION
    // =========================================
    if (!$id || !$date || !$start || !$duration || !$location) {
        header("Location: /TUTORLINK/Lessons/ViewLessons.php?error=Missing fields");
        exit();
    }

    if ($duration <= 0) {
        header("Location: /TUTORLINK/Lessons/ViewLessons.php?error=Invalid duration");
        exit();
    }

    // =========================================
    // CALCULATE END TIME
    // =========================================
    $end = date("H:i:s", strtotime("+$duration minutes", strtotime($start)));

    // =========================================
    // GET TUTOR FOR THIS LESSON
    // =========================================
    $res = $conn->query("SELECT TutorIndex FROM Lessons WHERE LessonID = $id");
    $tutorRow = $res->fetch_assoc();

    if (!$tutorRow) {
        header("Location: /TUTORLINK/Lessons/ViewLessons.php?error=Lesson not found");
        exit();
    }

    $tutor = $tutorRow['TutorIndex'];

    // =========================================
    // CONFLICT CHECK: TUTOR
    // =========================================
    $conflictSQL = "
    SELECT 1 FROM Lessons
    WHERE TutorIndex = $tutor
    AND LessonDate = '$date'
    AND LessonID != $id
    AND (StartTime < '$end' AND EndTime > '$start')
    ";

    $result = $conn->query($conflictSQL);

    if ($result->num_rows > 0) {
        header("Location: /TUTORLINK/Lessons/ViewLessons.php?error=Tutor already booked at this time");
        exit();
    }

    // =========================================
    // CONFLICT CHECK: LOCATION
    // =========================================
    $locationConflictSQL = "
    SELECT 1 FROM Lessons
    WHERE LocationIndex = $location
    AND LessonDate = '$date'
    AND LessonID != $id
    AND (StartTime < '$end' AND EndTime > '$start')
    ";

    $locResult = $conn->query($locationConflictSQL);

    if ($locResult->num_rows > 0) {
        header("Location: /TUTORLINK/Lessons/ViewLessons.php?error=Room already booked at this time");
        exit();
    }

    // =========================================
    // UPDATE LESSON
    // =========================================
    $sql = "UPDATE Lessons SET
        LessonDate='$date',
        StartTime='$start',
        EndTime='$end',
        Duration=$duration,
        LocationIndex=$location
    WHERE LessonID=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: /TUTORLINK/Lessons/ViewLessons.php?success=Lesson rescheduled successfully");
    } else {
        $error = urlencode($conn->error);
        header("Location: /TUTORLINK/Lessons/ViewLessons.php?error=$error");
    }

    exit();
}
?>