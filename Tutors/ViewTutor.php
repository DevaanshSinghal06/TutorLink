<?php
include '../PHP/db.php';

// =========================
// GET FILTER INPUTS
// =========================
$name = $_GET['name'] ?? '';
$type = $_GET['type'] ?? '';

// =========================
// BASE QUERY
// =========================
$sql = "
SELECT t.TutorIndex, t.FirstName, t.Surname, t.TutorType,
       GROUP_CONCAT(c.CoursePrefix, ' ', c.CourseNumber SEPARATOR ', ') AS Courses
FROM Tutors t
LEFT JOIN TutorSpecializations ts ON t.TutorIndex = ts.TutorIndex
LEFT JOIN Courses c ON ts.CourseIndex = c.CourseIndex
WHERE 1=1
";

// =========================
// APPLY FILTERS
// =========================
if (!empty($name)) {
    $name = $conn->real_escape_string($name);
    $sql .= " AND (t.FirstName LIKE '%$name%' OR t.Surname LIKE '%$name%')";
}

if (!empty($type)) {
    $type = $conn->real_escape_string($type);
    $sql .= " AND t.TutorType = '$type'";
}

// =========================
// GROUPING
// =========================
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

<div class="top-bar">The University of Texas at Dallas</div>

<div class="navbar">
    <a href="/TUTORLINK/Dashboard.php">Home</a>
    <a href="/TUTORLINK/Students/StudentsDashboard.php">Students</a>
    <a href="/TUTORLINK/Tutors/TutorsDashboard.php">Tutors</a>
    <a href="/TUTORLINK/Lessons/LessonsDashboard.php">Lessons</a>
</div>

<div class="container">

<h2>All Tutors</h2>

<!-- 🔥 SEARCH FORM -->
<form method="get">
    <input type="text" name="name" placeholder="Search name" value="<?php echo htmlspecialchars($name); ?>">

    <select name="type">
        <option value="">All Types</option>
        <option value="UTD" <?php if ($type == "UTD") echo "selected"; ?>>UTD</option>
        <option value="External" <?php if ($type == "External") echo "selected"; ?>>External</option>
    </select>

    <button type="submit">Search</button>
</form>

<table>
<tr>
    <th>Name</th>
    <th>Type</th>
    <th>Courses</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['FirstName'] . " " . $row['Surname']; ?></td>
    <td><?php echo $row['TutorType']; ?></td>
    <td><?php echo $row['Courses'] ?? "None"; ?></td>
    <td class="action-col">

        <a href="/TUTORLINK/Tutors/EditTutor.php?id=<?php echo $row['TutorIndex']; ?>"
        class="action-link">
        Edit
        </a>

        <span class="divider">|</span>

        <a href="/TUTORLINK/PHP/deleteTutor.php?id=<?php echo $row['TutorIndex']; ?>"
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