<?php
include '../PHP/db.php';

// =========================================
// FETCH RECENT TUTORS (LIMIT 5)
// =========================================
$result = $conn->query("
SELECT TutorIndex, FirstName, Surname, TutorType
FROM Tutors
ORDER BY TutorIndex DESC
LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tutors</title>
    <link rel="stylesheet" href="/TUTORLINK/CSS/styles.css">
</head>

<body>

<!-- HEADER -->
<div class="top-bar">TutorLink - Tutors</div>

<!-- NAV -->
<div class="navbar">
    <a href="/TUTORLINK/Dashboard.php">Home</a>
    <a href="/TUTORLINK/Students/StudentsDashboard.php">Students</a>
    <a href="/TUTORLINK/Tutors/TutorsDashboard.php">Tutors</a>
    <a href="/TUTORLINK/Lessons/LessonsDashboard.php">Lessons</a>
</div>

<div class="container">

<h2>Tutor Management</h2>

<!-- QUICK ACTIONS -->
<div style="display:flex; gap:15px;">
    <a href="/TUTORLINK/Tutors/AddTutorStep1.html"><button>Add Tutor</button></a>
    <a href="/TUTORLINK/Tutors/ViewTutor.php"><button>View All</button></a>
</div>

<!-- RECENT TUTORS TABLE -->
<h3 style="margin-top:30px;">Recent Tutors</h3>

<table>
<tr>
<th>Name</th>
<th>Type</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['FirstName'] . " " . $row['Surname']; ?></td>
<td><?= $row['TutorType']; ?></td>
<td>
    <a href="/TUTORLINK/Tutors/EditTutor.php?id=<?= $row['TutorIndex']; ?>" class="action-link">
        Edit
    </a>
</td>
</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>