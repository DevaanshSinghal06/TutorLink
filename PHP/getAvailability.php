<?php
// =========================================
// DB CONNECTION
// =========================================
include 'db.php';

// =========================================
// GET PARAMETERS (FROM FETCH REQUEST)
// =========================================
$tutor    = $_GET['tutor'];
$date     = $_GET['date'];
$location = $_GET['location'];
$duration = $_GET['duration'] ?? 30; // default to 30 minutes

// =========================================
// FETCH ROOM AVAILABILITY HOURS
// =========================================
$sql = "SELECT HoursAvailable FROM Locations WHERE LocationIndex = $location";
$result = $conn->query($sql);

// If location not found → return empty
if ($result->num_rows == 0) {
    echo json_encode([]);
    exit();
}

$row = $result->fetch_assoc();
$hours = $row['HoursAvailable']; // (not fully parsed yet, simplified below)

// =========================================
// DETERMINE DAY OF WEEK
// =========================================
// Example: Mon, Tue, Wed...
$day = date("D", strtotime($date));

// =========================================
// SET WORKING HOURS (SIMPLIFIED LOGIC)
// =========================================
$start = "09:00:00";
$end   = "21:00:00";

// Match day → assign room hours
if (in_array($day, ["Mon","Tue","Wed","Thu"])) {
    $start = "07:00:00";
    $end   = "23:59:00"; // approximation for 2AM
}
elseif ($day == "Fri") {
    $start = "07:00:00";
    $end   = "20:00:00";
}
elseif (in_array($day, ["Sat","Sun"])) {
    $start = "11:00:00";
    $end   = "20:00:00";
}

// =========================================
// GENERATE TIME SLOTS
// =========================================
$slots = [];
$current = strtotime($start);
$endTime = strtotime($end);

// Loop through time range
while ($current < $endTime) {

    // Define slot boundaries
    $slotStart = date("H:i:s", $current);
    $slotEnd   = date("H:i:s", strtotime("+$duration minutes", $current));

    // ❗ Prevent slots that exceed room hours
    if (strtotime($slotEnd) > $endTime) {
        break;
    }

    // =========================================
    // CONFLICT CHECK (TUTOR SCHEDULE)
    // =========================================
    $conflictSQL = "
    SELECT 1 FROM Lessons
    WHERE TutorIndex = $tutor
    AND LessonDate = '$date'
    AND (StartTime < '$slotEnd' AND EndTime > '$slotStart')
    ";

    $conflict = $conn->query($conflictSQL);

    // If no conflict → slot is available
    if ($conflict->num_rows == 0) {
        $slots[] = date("H:i", $current); // return HH:MM format
    }

    // Move forward by duration interval
    $current = strtotime("+$duration minutes", $current);
}

// =========================================
// RETURN JSON RESPONSE
// =========================================
echo json_encode($slots);