<?php
// =========================================
// DB CONNECTION
// =========================================
include '../PHP/db.php';

// Get tutor ID from URL
$id = $_GET['id'];

// =========================================
// FETCH TUTOR INFO
// =========================================
$result = $conn->query("SELECT * FROM Tutors WHERE TutorIndex = $id");
$row = $result->fetch_assoc();

// =========================================
// FETCH ALL COURSES (FOR LEFT BOX)
// =========================================
$courses = $conn->query("
    SELECT CourseIndex, CoursePrefix, CourseNumber, CourseName
    FROM Courses 
    ORDER BY CoursePrefix, CourseNumber
");

// =========================================
// FETCH CURRENT SPECIALIZATIONS
// =========================================
$current = $conn->query("
    SELECT CourseIndex 
    FROM TutorCourses 
    WHERE TutorIndex = $id
");

// Store selected course IDs in array
$selected = [];
while ($c = $current->fetch_assoc()) {
    $selected[] = $c['CourseIndex'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tutor</title>
    <link rel="stylesheet" href="/TUTORLINK/CSS/styles.css">
</head>

<body>

<div class="container">
<h2>Edit Tutor</h2>

<!-- =========================================
     MAIN UPDATE FORM
========================================= -->
<form action="/TUTORLINK/PHP/updateTutor.php" method="post">

<!-- Hidden ID -->
<input type="hidden" name="id" value="<?= $row['TutorIndex']; ?>">

<!-- BASIC INFO -->
<label>First Name</label>
<input type="text" name="firstName" value="<?= $row['FirstName']; ?>" required>

<label>Surname</label>
<input type="text" name="surname" value="<?= $row['Surname']; ?>">

<label>Age</label>
<input type="number" name="age" value="<?= $row['Age']; ?>" required>

<label>Phone</label>
<input type="text" name="phone" value="<?= $row['PhoneNumber']; ?>">

<label>Email</label>
<input type="email" name="email" value="<?= $row['Email']; ?>">

<label>Tutor Type</label>
<select name="tutorType">
    <option value="UTD" <?= $row['TutorType']=="UTD" ? "selected" : "" ?>>UTD</option>
    <option value="External" <?= $row['TutorType']=="External" ? "selected" : "" ?>>External</option>
</select>

<!-- =========================================
     DUAL LIST (COURSE MANAGEMENT)
========================================= -->
<h3>Courses of Specialization</h3>

<!-- Search filter -->
<label>Search Courses</label>
<input type="text" id="searchCourses" onkeyup="filterCourses()" placeholder="Search...">

<div class="dual-list">

    <!-- AVAILABLE COURSES -->
    <div>
        <label>Available</label>
        <select id="allCourses" size="12" multiple>
        <?php while($course = $courses->fetch_assoc()): ?>
            <?php if (!in_array($course['CourseIndex'], $selected)): ?>
                <option value="<?= $course['CourseIndex'] ?>">
                    <?= $course['CoursePrefix'] . " " . $course['CourseNumber'] . " - " . $course['CourseName'] ?>
                </option>
            <?php endif; ?>
        <?php endwhile; ?>
        </select>
    </div>

    <!-- MOVE BUTTONS -->
    <div class="dual-buttons">
        <button type="button" onclick="addCourse()">Add &gt;</button>
        <button type="button" onclick="removeCourse()">&lt; Remove</button>
    </div>

    <!-- SELECTED COURSES -->
    <div>
        <label>Selected</label>
        <select id="selectedCourses" name="courses[]" size="12" multiple>
        <?php
        // rewind result pointer to reuse
        $courses->data_seek(0);

        while($course = $courses->fetch_assoc()):
            if (in_array($course['CourseIndex'], $selected)):
        ?>
            <option value="<?= $course['CourseIndex'] ?>">
                <?= $course['CoursePrefix'] . " " . $course['CourseNumber'] . " - " . $course['CourseName'] ?>
            </option>
        <?php endif; endwhile; ?>
        </select>
    </div>

</div>

<button type="submit">Update Tutor</button>

</form>
</div>

<script>
// =========================================
// MOVE ITEMS BETWEEN LISTS
// =========================================
function addCourse() {
    moveOptions("allCourses", "selectedCourses");
}

function removeCourse() {
    moveOptions("selectedCourses", "allCourses");
}

function moveOptions(from, to) {
    const fromBox = document.getElementById(from);
    const toBox = document.getElementById(to);

    Array.from(fromBox.selectedOptions).forEach(option => {
        option.selected = true; // ensures it gets submitted
        toBox.appendChild(option);
    });
}

// =========================================
// CRITICAL: ENSURE ALL SELECTED COURSES SUBMIT
// =========================================
document.querySelector("form").addEventListener("submit", function () {
    const selected = document.getElementById("selectedCourses").options;

    for (let i = 0; i < selected.length; i++) {
        selected[i].selected = true;
    }
});

// =========================================
// SEARCH FILTER (AVAILABLE COURSES ONLY)
// =========================================
function filterCourses() {
    let input = document.getElementById("searchCourses").value.toLowerCase();
    let options = document.getElementById("allCourses").options;

    for (let i = 0; i < options.length; i++) {
        let text = options[i].text.toLowerCase();
        options[i].style.display = text.includes(input) ? "" : "none";
    }
}
</script>

</body>
</html>