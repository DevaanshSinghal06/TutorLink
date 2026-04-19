<?php
include '../PHP/db.php';

// Get recent lessons
$result = $conn->query("
SELECT l.LessonID, s.FirstName AS Student, t.FirstName AS Tutor, l.LessonDate
FROM Lessons l
JOIN Students s ON l.StudentIndex = s.StudentIndex
JOIN Tutors t ON l.TutorIndex = t.TutorIndex
ORDER BY l.LessonDate DESC
LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lessons</title>
    <link rel="stylesheet" href="/TUTORLINK/CSS/styles.css">
</head>

<body>

<div class="top-bar">TutorLink - Lessons</div>

<div class="navbar">
    <a href="/TUTORLINK/Dashboard.php">Home</a>
    <a href="/TUTORLINK/Students/StudentsDashboard.php">Students</a>
    <a href="/TUTORLINK/Tutors/TutorsDashboard.php">Tutors</a>
    <a href="/TUTORLINK/Lessons/LessonsDashboard.php">Lessons</a>
</div>

<div class="container">

<h2>Lesson Management</h2>

<!-- ACTIONS -->
<div style="display:flex; gap:15px;">
    <a href="/TUTORLINK/Lessons/AddLesson.php"><button>Book Lesson</button></a>
    <a href="/TUTORLINK/Lessons/ViewLessons.php"><button>View All</button></a>
</div>

<!-- LIVE PREVIEW -->
<h3 style="margin-top:30px;">Recent Lessons</h3>

<table>
<tr>
<th>Student</th>
<th>Tutor</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?php echo $row['Student']; ?></td>
<td><?php echo $row['Tutor']; ?></td>
<td><?php echo $row['LessonDate']; ?></td>
<td>
    <a href="/TUTORLINK/Lessons/EditLesson.php?id=<?php echo $row['LessonID']; ?>" class="action-link">
        Edit
    </a>
</td>
</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>