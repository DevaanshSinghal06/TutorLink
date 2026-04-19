<?php
require_once '../PHP/db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    <title>UTD Tutor Details</title>
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

<h2>UTD Tutor Details</h2>

<form action="/TUTORLINK/PHP/addTutor.php" method="post">

    <!-- Hidden fields -->
    <input type="hidden" name="firstName" id="firstName">
    <input type="hidden" name="surname" id="surname">
    <input type="hidden" name="age" id="age">
    <input type="hidden" name="phone" id="phone">
    <input type="hidden" name="email" id="email">
    <input type="hidden" name="tutorType" value="UTD">

    <!-- UTD fields -->
    <label>NetID</label>
    <input type="text" name="netid" required>

    <label>Comet ID</label>
    <input type="text" name="cometid" required>

    <!-- Filters -->
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

    <!-- Courses -->
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
// Transfer Step 1 data
const params = new URLSearchParams(window.location.search);
["firstName","surname","age","phone","email"].forEach(id => {
    document.getElementById(id).value = params.get(id) || '';
});

// Search filter
function filterCourses() {
    let input = document.getElementById("searchBox").value.toLowerCase();
    let options = document.getElementById("courseSelect").options;

    for (let i = 0; i < options.length; i++) {
        let text = options[i].text.toLowerCase();
        options[i].style.display = text.includes(input) ? "" : "none";
    }
}

// Prefix filter
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