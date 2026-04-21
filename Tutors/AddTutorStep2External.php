<?php
// =========================================
// DATABASE CONNECTION
// =========================================
require_once '../PHP/db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// =========================================
// FETCH ALL COURSES FOR SELECTION
// =========================================
$sql = "SELECT CourseIndex, CoursePrefix, CourseNumber, CourseName 
        FROM Courses 
        ORDER BY CoursePrefix, CourseNumber";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>External Tutor</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>

<!-- NAV -->
<div class="top-bar">The University of Texas at Dallas</div>

<div class="navbar">
    <a href="/TUTORLINK/Dashboard.php">Home</a>
    <a href="/TUTORLINK/Students/StudentsDashboard.php">Students</a>
    <a href="/TUTORLINK/Tutors/TutorsDashboard.php">Tutors</a>
    <a href="/TUTORLINK/Lessons/LessonsDashboard.php">Lessons</a>
</div>

<div class="container">

<h2>External Tutor Details</h2>

<!-- =========================================
     STEP 2 FORM (EXTERNAL TUTOR)
     Receives Step 1 data via URL params
========================================= -->
<form action="../PHP/addTutor.php" method="post">

    <!-- Hidden fields from Step 1 -->
    <input type="hidden" name="firstName" id="firstName">
    <input type="hidden" name="surname" id="surname">
    <input type="hidden" name="age" id="age">
    <input type="hidden" name="phone" id="phone">
    <input type="hidden" name="email" id="email">
    <input type="hidden" name="tutorType" value="External">

    <!-- External-specific fields -->
    <label>Tutor ID</label>
    <input type="text" name="tutorid" required>

    <label>Company</label>
    <input type="text" name="company">

    <label>Other Info</label>
    <input type="text" name="other">

    <!-- =========================================
         COURSE FILTERING UI
    ========================================= -->
    <label>Search Courses</label>
    <input type="text" id="searchBox" placeholder="Search courses..." onkeyup="filterCourses()">

    <label>Filter by Prefix</label>
    <select id="prefixFilter" onchange="filterByPrefix()">
        <option value="">All</option>
        <option value="CS">CS</option>
        <option value="SE">SE</option>
        <option value="MATH">MATH</option>
        <option value="STAT">STAT</option>
        <option value="ECON">ECON</option>
        <option value="FIN">FIN</option>
        <option value="PSY">PSY</option>
    </select>

    <!-- Multi-select course list -->
    <p><i>Hold Command (Mac) or Ctrl (Windows) to select multiple courses</i></p>

    <label>Courses Taught</label>
    <select name="courses[]" id="courseSelect" multiple required size="12">

        <?php while($row = $result->fetch_assoc()): ?>
            <option value="<?= $row['CourseIndex'] ?>">
                <?= $row['CoursePrefix'] . " " . $row['CourseNumber'] . " -- " . $row['CourseName'] ?>
            </option>
        <?php endwhile; ?>

    </select>

    <button type="submit">Complete Registration</button>

</form>

</div>

<script>
// =========================================
// TRANSFER STEP 1 DATA (FROM URL PARAMS)
// =========================================
const params = new URLSearchParams(window.location.search);

["firstName","surname","age","phone","email"].forEach(id => {
    document.getElementById(id).value = params.get(id) || '';
});

// =========================================
// SEARCH FILTER (TEXT MATCH)
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
// PREFIX FILTER (CS / MATH / etc.)
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
</script>

</body>
</html>