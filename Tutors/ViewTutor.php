<?php
include '../PHP/db.php';

// =========================================
// FILTER INPUTS
// =========================================
$name = $_GET['name'] ?? '';
$type = $_GET['type'] ?? '';

// =========================================
// BASE QUERY (WITH COURSE AGGREGATION)
// =========================================
$sql = "
SELECT 
    t.TutorIndex, 
    t.FirstName, 
    t.Surname, 
    t.TutorType,
    GROUP_CONCAT(CONCAT(c.CoursePrefix, ' ', c.CourseNumber) SEPARATOR ', ') AS Courses
FROM Tutors t
LEFT JOIN TutorCourses tc ON t.TutorIndex = tc.TutorIndex
LEFT JOIN Courses c ON tc.CourseIndex = c.CourseIndex
WHERE 1=1
";

// =========================================
// APPLY SEARCH FILTER (NAME)
// =========================================
if (!empty($name)) {
    $name = $conn->real_escape_string($name);
    $sql .= " AND (t.FirstName LIKE '%$name%' OR t.Surname LIKE '%$name%')";
}

// =========================================
// APPLY TYPE FILTER
// =========================================
if (!empty($type)) {
    $type = $conn->real_escape_string($type);
    $sql .= " AND t.TutorType = '$type'";
}

// =========================================
// GROUP RESULTS BY TUTOR
// =========================================
$sql .= " GROUP BY t.TutorIndex";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Tutors</title>
    <link rel="stylesheet" href="/TUTORLINK/CSS/styles.css">
</head>

<body>

<!-- HEADER -->
<div class="top-bar">The University of Texas at Dallas</div>

<!-- NAV -->
<div class="navbar">
    <a href="/TUTORLINK/Dashboard.php">Home</a>
    <a href="/TUTORLINK/Students/StudentsDashboard.php">Students</a>
    <a href="/TUTORLINK/Tutors/TutorsDashboard.php">Tutors</a>
    <a href="/TUTORLINK/Lessons/LessonsDashboard.php">Lessons</a>
</div>

<div class="container">

<h2>All Tutors</h2>

<!-- =========================================
     FILTER FORM
========================================= -->
<form method="get">
    <input type="text" name="name" placeholder="Search name" value="<?= htmlspecialchars($name); ?>">

    <select name="type">
        <option value="">All Types</option>
        <option value="UTD" <?= $type=="UTD" ? "selected" : "" ?>>UTD</option>
        <option value="External" <?= $type=="External" ? "selected" : "" ?>>External</option>
    </select>

    <button type="submit">Search</button>
</form>

<!-- =========================================
     TUTOR TABLE
========================================= -->
<table>
<tr>
    <th>Name</th>
    <th>Type</th>
    <th>Courses</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>

<td><?= $row['FirstName'] . " " . $row['Surname']; ?></td>

<td><?= $row['TutorType']; ?></td>

<td>
<?php 
    echo !empty($row['Courses']) 
        ? $row['Courses'] 
        : "<i>No specializations</i>";
?>
</td>

<td class="action-col">

    <a href="/TUTORLINK/Tutors/EditTutor.php?id=<?= $row['TutorIndex']; ?>" class="action-link">
        Edit
    </a>

    <span class="divider">|</span>

    <a href="/TUTORLINK/PHP/deleteTutor.php?id=<?= $row['TutorIndex']; ?>"
       onclick="return confirm('Are you sure you want to delete this tutor?');"
       class="action-link delete">
        Delete
    </a>

</td>

</tr>
<?php endwhile; ?>

</table>

</div>

<!-- SUCCESS TOAST -->
<div id="successToast" class="toast"></div>

<script>
// Show success toast if redirected with message
const params = new URLSearchParams(window.location.search);
const success = params.get('success');

if (success) {
    const toast = document.getElementById('successToast');
    toast.innerHTML = "✔ " + success;
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}
</script>

</body>
</html>