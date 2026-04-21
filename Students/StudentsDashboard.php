<?php
// =========================================
// DATABASE CONNECTION
// =========================================
include '../PHP/db.php';

// =========================================
// FETCH RECENT STUDENTS (LIMIT 5)
// =========================================
$result = $conn->query("SELECT * FROM Students ORDER BY StudentIndex DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Students</title>
    <link rel="stylesheet" href="/TUTORLINK/CSS/styles.css">
</head>

<body>

<!-- TOP BAR -->
<div class="top-bar">TutorLink - Students</div>

<!-- NAVBAR -->
<div class="navbar">
    <a href="/TUTORLINK/Dashboard.php">Home</a>
    <a href="/TUTORLINK/Students/StudentsDashboard.php">Students</a>
    <a href="/TUTORLINK/Tutors/TutorsDashboard.php">Tutors</a>
    <a href="/TUTORLINK/Lessons/LessonsDashboard.php">Lessons</a>
</div>

<div class="container">

<h2>Student Management</h2>

<!-- =========================================
     QUICK ACTION BUTTONS
========================================= -->
<div style="display:flex; gap:15px;">
    <a href="/TUTORLINK/Students/AddStudents.html"><button>Add Student</button></a>
    <a href="/TUTORLINK/Students/ViewStudents.php"><button>View All</button></a>
</div>

<!-- =========================================
     RECENT STUDENTS PREVIEW
========================================= -->
<h3 style="margin-top:30px;">Recent Students</h3>

<table>
<tr>
<th>Name</th>
<th>Email</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>

<td><?php echo $row['FirstName'] . " " . $row['Surname']; ?></td>

<td><?php echo $row['Email']; ?></td>

<td>
    <a href="/TUTORLINK/Students/EditStudent.php?id=<?php echo $row['StudentIndex']; ?>" class="action-link">
        Edit
    </a>
</td>

</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>