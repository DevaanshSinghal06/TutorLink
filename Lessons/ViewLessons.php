<?php
// =========================================
// DATABASE CONNECTION
// =========================================
include '../PHP/db.php';

// =========================================
// FETCH ALL LESSON DATA (JOINED VIEW)
// Combines Students, Tutors, Locations, Courses
// =========================================
$sql = "
SELECT 
    l.LessonID,
    s.FirstName AS StudentName,
    s.Surname AS StudentSurname,
    t.FirstName AS TutorName,
    t.Surname AS TutorSurname,
    l.LessonDate,
    l.StartTime,
    l.EndTime,
    l.Status,
    c.CoursePrefix,
    c.CourseNumber,
    l.Topic,
    loc.BuildingID,
    loc.RoomNumber
FROM Lessons l
JOIN Students s ON l.StudentIndex = s.StudentIndex
JOIN Tutors t ON l.TutorIndex = t.TutorIndex
JOIN Locations loc ON l.LocationIndex = loc.LocationIndex
LEFT JOIN Courses c ON l.CourseIndex = c.CourseIndex
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Lessons</title>
    <link rel="stylesheet" href="/TUTORLINK/CSS/styles.css">
</head>

<body>

<!-- TOP BAR -->
<div class="top-bar">The University of Texas at Dallas</div>

<!-- NAVBAR -->
<div class="navbar">
    <a href="/TUTORLINK/Dashboard.php">Home</a>
    <a href="/TUTORLINK/Students/StudentsDashboard.php">Students</a>
    <a href="/TUTORLINK/Tutors/TutorsDashboard.php">Tutors</a>
    <a href="/TUTORLINK/Lessons/LessonsDashboard.php">Lessons</a>
</div>

<div class="container">

<h2>All Lessons</h2>

<!-- LESSON TABLE -->
<table>
<tr>
<th>Student</th>
<th>Tutor</th>
<th>Course / Topic</th>
<th>Location</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th class="action-col">Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>

<!-- Student -->
<td><?php echo $row['StudentName'] . " " . $row['StudentSurname']; ?></td>

<!-- Tutor -->
<td><?php echo $row['TutorName'] . " " . $row['TutorSurname']; ?></td>

<!-- Course OR Topic -->
<td>
<?php
if (!empty($row['CoursePrefix'])) {
    echo $row['CoursePrefix'] . " " . $row['CourseNumber'];
} else {
    echo $row['Topic'];
}
?>
</td>

<!-- Location -->
<td><?php echo $row['BuildingID'] . " " . $row['RoomNumber']; ?></td>

<!-- Date -->
<td><?php echo $row['LessonDate']; ?></td>

<!-- Time Range -->
<td><?php echo substr($row['StartTime'],0,5) . " - " . substr($row['EndTime'],0,5); ?></td>

<!-- Status -->
<td class="status <?php echo strtolower(str_replace(' ', '-', $row['Status'])); ?>">
    <?php echo $row['Status']; ?>
</td>

<!-- Actions -->
<td class="action-col">

    <a href="/TUTORLINK/Lessons/EditLesson.php?id=<?php echo $row['LessonID']; ?>" class="action-link">
        Edit
    </a>

    <span class="divider">|</span>

    <a href="/TUTORLINK/PHP/deleteLesson.php?id=<?php echo $row['LessonID']; ?>"
       onclick="return confirm('Are you sure you want to delete this lesson?');"
       class="action-link delete">
        Delete
    </a>

    <span class="divider">|</span>

    <a href="/TUTORLINK/PHP/updateLesson.php?id=<?php echo $row['LessonID']; ?>&status=Cancelled"
       class="action-link cancel">
        Cancel
    </a>

    <span class="divider">|</span>

    <a href="/TUTORLINK/PHP/updateLesson.php?id=<?php echo $row['LessonID']; ?>&status=No Show"
       class="action-link noshow">
        No Show
    </a>

</td>

</tr>
<?php endwhile; ?>

</table>

</div>

<!-- SUCCESS TOAST -->
<div id="successToast" class="toast"></div>

<script>
// Show success message if present in URL
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