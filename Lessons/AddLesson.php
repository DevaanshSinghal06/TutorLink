<?php
include '../PHP/db.php';

// Fetch dynamic data
$students = $conn->query("SELECT StudentIndex, FirstName, Surname FROM Students");
$tutors = $conn->query("SELECT TutorIndex, FirstName, Surname FROM Tutors");
$locations = $conn->query("SELECT LocationIndex, BuildingID, RoomNumber, RoomName FROM Locations");
$courses = $conn->query("
    SELECT CourseIndex, CoursePrefix, CourseNumber, CourseName 
    FROM Courses 
    ORDER BY CoursePrefix, CourseNumber
");

// 🔥 Tutor ↔ Course mapping
$tutorCourses = $conn->query("SELECT TutorIndex, CourseIndex FROM TutorCourses");

$map = [];
while ($row = $tutorCourses->fetch_assoc()) {
    $map[$row['CourseIndex']][] = $row['TutorIndex'];
}

// Error message
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

<div class="top-bar">The University of Texas at Dallas</div>

<div class="navbar">
    <a href="/TUTORLINK/Dashboard.php">Home</a>
    <a href="/TUTORLINK/Students/StudentsDashboard.php">Students</a>
    <a href="/TUTORLINK/Tutors/TutorsDashboard.php">Tutors</a>
    <a href="/TUTORLINK/Lessons/LessonsDashboard.php">Lessons</a>
</div>

<div class="container">

<h2>Book a Tutoring Session</h2>

<?php if ($error): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form action="/TUTORLINK/PHP/addLesson.php" method="post">

<!-- STUDENT -->
<h3>Student</h3>
<select name="studentIndex" required>
<?php while($row = $students->fetch_assoc()) { ?>
    <option value="<?= $row['StudentIndex']; ?>">
        <?= $row['FirstName'] . " " . $row['Surname']; ?>
    </option>
<?php } ?>
</select>

<!-- TUTOR -->
<h3>Tutor</h3>
<select name="tutorIndex" id="tutorSelect" required>
<?php while($row = $tutors->fetch_assoc()) { ?>
    <option value="<?= $row['TutorIndex']; ?>">
        <?= $row['FirstName'] . " " . $row['Surname']; ?>
    </option>
<?php } ?>
</select>

<!-- LOCATION -->
<h3>Location</h3>
<select name="locationIndex" required>
<?php while($row = $locations->fetch_assoc()) { ?>
    <option value="<?= $row['LocationIndex']; ?>">
        <?= $row['BuildingID'] . " " . $row['RoomNumber'] . " - " . $row['RoomName']; ?>
    </option>
<?php } ?>
</select>

<!-- LESSON DETAILS -->
<h3>Lesson Details</h3>

<label>Search Courses</label>
<input type="text" id="searchBox" onkeyup="filterCourses()" placeholder="Search courses...">

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

<select name="courseIndex" id="courseSelect" size="10">
    <option value="">--Select Course--</option>

    <?php while($row = $courses->fetch_assoc()): ?>
        <option value="<?= $row['CourseIndex'] ?>">
            <?= $row['CoursePrefix'] . " " . $row['CourseNumber'] . " -- " . $row['CourseName'] ?>
        </option>
    <?php endwhile; ?>

</select>

<input type="text" name="topic" id="topicInput" placeholder="Or enter topic">

<!-- SCHEDULE -->
<h3>Schedule</h3>

<div class="date-group">
    <label>Date</label>
    <input type="date" name="lessonDate" required>

    <button type="button" class="inline-button" onclick="loadAvailability()">
        Check Availability
    </button>
</div>
<div id="availabilityResults"></div>

<div class="schedule-section">
    <label>Start Time</label>
    <input type="time" name="startTime" required>

    <label>Duration (minutes)</label>
    <input type="number" name="duration" min="15" max="120" step="5">

    <p class="duration-note">
    * If no duration is selected, availability defaults to 30 minutes.
    </p>
</div>

<button type="submit">Book Session</button>

</form>

</div>

<script>
// 🔥 Tutor-course map from PHP
const tutorCourseMap = <?php echo json_encode($map); ?>;

// SEARCH
function filterCourses() {
    let input = document.getElementById("searchBox").value.toLowerCase();
    let options = document.getElementById("courseSelect").options;

    for (let i = 0; i < options.length; i++) {
        let text = options[i].text.toLowerCase();
        options[i].style.display = text.includes(input) ? "" : "none";
    }
}

// PREFIX FILTER
function filterByPrefix() {
    let prefix = document.getElementById("prefixFilter").value;
    let options = document.getElementById("courseSelect").options;

    for (let i = 0; i < options.length; i++) {
        let text = options[i].text;
        options[i].style.display =
            (prefix === "" || text.startsWith(prefix)) ? "" : "none";
    }
}

// COURSE → TUTOR FILTER
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

    // topic lock
    if (course.value !== "") {
        topic.value = "";
        topic.disabled = true;
    } else {
        topic.disabled = false;
    }
});

// TOPIC LOCK
topic.addEventListener('input', () => {
    if (topic.value.trim() !== "") {
        course.value = "";
        course.disabled = true;
    } else {
        course.disabled = false;
    }
});

// AVAILABILITY

function loadAvailability() {
    const tutor = document.getElementById("tutorSelect").value;
    const date = document.querySelector("input[name='lessonDate']").value;

    if (!tutor || !date) {
        alert("Please select both a tutor and a date first.");
        return;
    }

    const location = document.querySelector("select[name='locationIndex']").value;
    const durationInput = document.querySelector("input[name='duration']");
    let duration = durationInput.value;
    if (!duration) duration = 30; // default
    fetch(`/TUTORLINK/PHP/getAvailability.php?tutor=${tutor}&date=${date}&location=${location}&duration=${duration}`)
        .then(res => res.json()) // 🔥 CHANGE HERE
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

function selectTime(time) {
    document.querySelector("input[name='startTime']").value = time;

    // remove previous selection
    document.querySelectorAll('.time-slot').forEach(btn => {
        btn.classList.remove('selected');
    });

    // highlight clicked button
    event.target.classList.add('selected');
}
</script>

</body>
</html>