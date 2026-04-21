<?php
// =========================================
// DATABASE CONNECTION
// =========================================
include '../PHP/db.php';

// =========================================
// FETCH DATA FOR DROPDOWNS
// =========================================

// Students list
$students = $conn->query("SELECT StudentIndex, FirstName, Surname FROM Students");

// Tutors list
$tutors = $conn->query("SELECT TutorIndex, FirstName, Surname FROM Tutors");

// Locations list (includes room name for UI clarity)
$locations = $conn->query("SELECT LocationIndex, BuildingID, RoomNumber, RoomName FROM Locations");

// Courses list (sorted for usability)
$courses = $conn->query("
    SELECT CourseIndex, CoursePrefix, CourseNumber, CourseName 
    FROM Courses 
    ORDER BY CoursePrefix, CourseNumber
");

// =========================================
// BUILD COURSE → TUTOR MAP
// Used for frontend filtering (course selection limits tutors)
// =========================================
$tutorCourses = $conn->query("SELECT TutorIndex, CourseIndex FROM TutorCourses");

$map = [];
while ($row = $tutorCourses->fetch_assoc()) {
    $map[$row['CourseIndex']][] = $row['TutorIndex'];
}

// Error message (if redirected from backend)
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Book Lesson</title>
    <link rel="stylesheet" href="/TUTORLINK/CSS/styles.css">
</head>

<body>

<!-- TOP BAR -->
<div class="top-bar">The University of Texas at Dallas</div>

<!-- NAVIGATION -->
<div class="navbar">
    <a href="/TUTORLINK/Dashboard.php">Home</a>
    <a href="/TUTORLINK/Students/StudentsDashboard.php">Students</a>
    <a href="/TUTORLINK/Tutors/TutorsDashboard.php">Tutors</a>
    <a href="/TUTORLINK/Lessons/LessonsDashboard.php">Lessons</a>
</div>

<div class="container">

<h2>Book a Tutoring Session</h2>

<!-- ERROR DISPLAY -->
<?php if ($error): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<!-- MAIN FORM -->
<form action="/TUTORLINK/PHP/addLesson.php" method="post">

<!-- =========================================
     STUDENT SELECTION
========================================= -->
<h3>Student</h3>
<select name="studentIndex" required>
<?php while($row = $students->fetch_assoc()) { ?>
    <option value="<?= $row['StudentIndex']; ?>">
        <?= $row['FirstName'] . " " . $row['Surname']; ?>
    </option>
<?php } ?>
</select>

<!-- =========================================
     TUTOR SELECTION
========================================= -->
<h3>Tutor</h3>
<select name="tutorIndex" id="tutorSelect" required>
<?php while($row = $tutors->fetch_assoc()) { ?>
    <option value="<?= $row['TutorIndex']; ?>">
        <?= $row['FirstName'] . " " . $row['Surname']; ?>
    </option>
<?php } ?>
</select>

<!-- =========================================
     LOCATION SELECTION
========================================= -->
<h3>Location</h3>
<select name="locationIndex" required>
<?php while($row = $locations->fetch_assoc()) { ?>
    <option value="<?= $row['LocationIndex']; ?>">
        <?= $row['BuildingID'] . " " . $row['RoomNumber'] . " - " . $row['RoomName']; ?>
    </option>
<?php } ?>
</select>

<!-- =========================================
     LESSON DETAILS (COURSE / TOPIC)
========================================= -->
<h3>Lesson Details</h3>

<!-- Course search -->
<label>Search Courses</label>
<input type="text" id="searchBox" onkeyup="filterCourses()" placeholder="Search courses...">

<!-- Prefix filter -->
<label>Filter by Prefix</label>
<select id="prefixFilter" onchange="filterByPrefix()">
    <option value="">All</option>
    <option value="CS">CS</option>
    <option value="SE">SE</option>
    <option value="MATH">MATH</option>
    <option value="STAT">STAT</option>
    <option value="FIN">FIN</option>
    <option value="PSY">PSY</option>
</select>

<!-- Course list -->
<select name="courseIndex" id="courseSelect" size="10">
    <option value="">--Select Course--</option>
    <?php while($row = $courses->fetch_assoc()): ?>
        <option value="<?= $row['CourseIndex'] ?>">
            <?= $row['CoursePrefix'] . " " . $row['CourseNumber'] . " -- " . $row['CourseName'] ?>
        </option>
    <?php endwhile; ?>
</select>

<!-- Topic alternative -->
<input type="text" name="topic" id="topicInput" placeholder="Or enter topic">

<!-- =========================================
     SCHEDULING SECTION
========================================= -->
<h3>Schedule</h3>

<!-- Date + Availability -->
<div class="date-group">
    <label>Date</label>
    <input type="date" name="lessonDate" required>

    <!-- Triggers backend availability API -->
    <button type="button" class="inline-button" onclick="loadAvailability()">
        Check Availability
    </button>
</div>

<!-- Availability results render here -->
<div id="availabilityResults"></div>

<!-- Time + Duration -->
<div class="schedule-section">
    <label>Start Time</label>
    <input type="time" name="startTime" required>

    <label>Duration (minutes)</label>
    <input type="number" name="duration" min="15" max="120" step="5">

    <!-- UX note for default duration -->
    <p class="duration-note">
        * If no duration is selected, availability defaults to 30 minutes.
    </p>
</div>

<button type="submit">Book Session</button>

</form>

</div>

<script>
// =========================================
// COURSE → TUTOR FILTER MAP (from PHP)
// =========================================
const tutorCourseMap = <?php echo json_encode($map); ?>;

// =========================================
// COURSE SEARCH (TEXT FILTER)
// =========================================
function filterCourses() {
    let input = document.getElementById("searchBox").value.toLowerCase();
    let options = document.getElementById("courseSelect").options;

    for (let i = 0; i < options.length; i++) {
        let text = options[i].text.toLowerCase();
        options[i].style.display = text.includes(input) ? "" : "none";
    }
}

// =========================================
// PREFIX FILTER (CS, MATH, etc.)
// =========================================
function filterByPrefix() {
    let prefix = document.getElementById("prefixFilter").value;
    let options = document.getElementById("courseSelect").options;

    for (let i = 0; i < options.length; i++) {
        let text = options[i].text;
        options[i].style.display =
            (prefix === "" || text.startsWith(prefix)) ? "" : "none";
    }
}

// =========================================
// COURSE → TUTOR FILTER LOGIC
// Ensures only qualified tutors appear
// =========================================
const course = document.getElementById('courseSelect');
const topic = document.getElementById('topicInput');

course.addEventListener('change', () => {
    const selectedCourse = course.value;
    const tutorSelect = document.getElementById("tutorSelect");
    const tutors = tutorSelect.options;

    for (let i = 0; i < tutors.length; i++) {
        let tutorID = tutors[i].value;

        if (!selectedCourse) {
            tutors[i].style.display = "";
        } else {
            let allowed = tutorCourseMap[selectedCourse] || [];
            tutors[i].style.display =
                allowed.includes(parseInt(tutorID)) ? "" : "none";
        }
    }

    // Lock topic if course selected
    topic.disabled = course.value !== "";
    if (course.value !== "") topic.value = "";
});

// =========================================
// TOPIC → COURSE LOCK
// Prevents both being used at once
// =========================================
topic.addEventListener('input', () => {
    course.disabled = topic.value.trim() !== "";
    if (topic.value.trim() !== "") course.value = "";
});

// =========================================
// LOAD AVAILABILITY (API CALL)
// =========================================
function loadAvailability() {
    const tutor = document.getElementById("tutorSelect").value;
    const date = document.querySelector("input[name='lessonDate']").value;

    if (!tutor || !date) {
        alert("Please select both a tutor and a date first.");
        return;
    }

    const location = document.querySelector("select[name='locationIndex']").value;

    let duration = document.querySelector("input[name='duration']").value;
    if (!duration) duration = 30; // default

    fetch(`/TUTORLINK/PHP/getAvailability.php?tutor=${tutor}&date=${date}&location=${location}&duration=${duration}`)
        .then(res => res.json())
        .then(slots => {

            const output = document.getElementById("availabilityResults");

            if (slots.length === 0) {
                output.innerHTML = "<div class='availability-box'>No availability</div>";
                return;
            }

            let html = `
            <div class="availability-box">
                <strong>Available Times (${duration} min sessions):</strong><br><br>
                <div class="time-grid">
            `;

            slots.forEach(time => {
                html += `<button class="time-slot" onclick="selectTime('${time}')">${time}</button>`;
            });

            html += `</div></div>`;

            output.innerHTML = html;
        });
}

// =========================================
// SELECT TIME SLOT
// =========================================
function selectTime(time) {
    document.querySelector("input[name='startTime']").value = time;

    document.querySelectorAll('.time-slot').forEach(btn => {
        btn.classList.remove('selected');
    });

    event.target.classList.add('selected');
}
</script>

</body>
</html>