<?php
include 'db.php';

$tutor    = $_GET['tutor'];
$date     = $_GET['date'];
$location = $_GET['location'];
$duration = $_GET['duration'] ?? 30;

// =========================
// GET ROOM HOURS
// =========================
$sql = "SELECT HoursAvailable FROM Locations WHERE LocationIndex = $location";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo json_encode([]);
    exit();
}

$row = $result->fetch_assoc();
$hours = $row['HoursAvailable'];

// =========================
// DETERMINE DAY OF WEEK
// =========================
$day = date("D", strtotime($date)); // Mon, Tue, etc

// =========================
// PARSE HOURS (SIMPLE VERSION)
// =========================
$start = "09:00:00";
$end   = "21:00:00";

// 🔥 Match based on day
if (in_array($day, ["Mon","Tue","Wed","Thu"])) {
    $start = "07:00:00";
    $end   = "23:59:00"; // simplify 2AM → end of day
}
elseif ($day == "Fri") {
    $start = "07:00:00";
    $end   = "20:00:00";
}
elseif (in_array($day, ["Sat","Sun"])) {
    $start = "11:00:00";
    $end   = "20:00:00";
}

// =========================
// GENERATE TIME SLOTS
// =========================
$slots = [];
$current = strtotime($start);
$endTime = strtotime($end);

while ($current < $endTime) {

    $slotStart = date("H:i:s", $current);
    $slotEnd   = date("H:i:s", strtotime("+$duration minutes", $current));

    // ❗ Don't allow slot to exceed room hours
    if (strtotime($slotEnd) > $endTime) {
        break;
    }

    $conflictSQL = "
    SELECT 1 FROM Lessons
    WHERE TutorIndex = $tutor
    AND LessonDate = '$date'
    AND (StartTime < '$slotEnd' AND EndTime > '$slotStart')
    ";

    $conflict = $conn->query($conflictSQL);

    if ($conflict->num_rows == 0) {
        $slots[] = date("H:i", $current);
    }

    $current = strtotime("+$duration minutes", $current);
}

// =========================
// RETURN JSON
// =========================
echo json_encode($slots);