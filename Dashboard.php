<?php
// =========================================
// DATABASE CONNECTION
// =========================================
include 'PHP/db.php';

// =========================================
// FETCH DASHBOARD METRICS
// Retrieves total counts for key entities
// =========================================
$students = $conn->query("SELECT COUNT(*) as count FROM Students")->fetch_assoc()['count'];
$tutors   = $conn->query("SELECT COUNT(*) as count FROM Tutors")->fetch_assoc()['count'];
$lessons  = $conn->query("SELECT COUNT(*) as count FROM Lessons")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <!-- Global stylesheet -->
    <link rel="stylesheet" href="CSS/styles.css">
</head>

<body>

<!-- =========================================
     TOP BAR
========================================= -->
<div class="top-bar">TutorLink Dashboard</div>

<!-- =========================================
     NAVIGATION BAR
========================================= -->
<div class="navbar">
    <a href="/TUTORLINK/Dashboard.php">Home</a>
    <a href="/TUTORLINK/Students/StudentsDashboard.php">Students</a>
    <a href="/TUTORLINK/Tutors/TutorsDashboard.php">Tutors</a>
    <a href="/TUTORLINK/Lessons/LessonsDashboard.php">Lessons</a>
</div>

<div class="container">

<h2>Dashboard</h2>
<p>Welcome to TutorLink.</p>

<!-- =========================================
     DASHBOARD SUMMARY CARDS
     Displays total counts for quick overview
========================================= -->
<div style="display:flex; gap:20px; margin-top:20px;">

    <!-- Students -->
    <div style="flex:1; padding:20px; background:#f9f9f9; text-align:center;">
        <h3>Students</h3>
        <p style="font-size:28px; font-weight:bold;">
            <?php echo $students; ?>
        </p>
        <a href="/TUTORLINK/Students/ViewStudents.php">View</a>
    </div>

    <!-- Tutors -->
    <div style="flex:1; padding:20px; background:#f9f9f9; text-align:center;">
        <h3>Tutors</h3>
        <p style="font-size:28px; font-weight:bold;">
            <?php echo $tutors; ?>
        </p>
        <a href="/TUTORLINK/Tutors/ViewTutor.php">View</a>
    </div>

    <!-- Lessons -->
    <div style="flex:1; padding:20px; background:#f9f9f9; text-align:center;">
        <h3>Lessons</h3>
        <p style="font-size:28px; font-weight:bold;">
            <?php echo $lessons; ?>
        </p>
        <a href="/TUTORLINK/Lessons/ViewLessons.php">View</a>
    </div>

</div>

<!-- =========================================
     QUICK ACTIONS
     Direct shortcuts to common operations
========================================= -->
<h3 style="margin-top:40px;">Quick Actions</h3>

<div style="display:flex; gap:20px; margin-top:10px;">

    <a href="/TUTORLINK/Students/AddStudents.html">
        <button>Add Student</button>
    </a>

    <a href="/TUTORLINK/Tutors/AddTutorStep1.html">
        <button>Add Tutor</button>
    </a>

    <a href="/TUTORLINK/Lessons/AddLesson.php">
        <button>Book Lesson</button>
    </a>

</div>

</div>

<!-- =========================================
     SUCCESS TOAST NOTIFICATION
     Displays feedback messages via URL params
========================================= -->
<div id="successToast" class="toast"></div>

<script>
// Extract success message from URL query
const params = new URLSearchParams(window.location.search);
const success = params.get('success');

// Show toast if message exists
if (success) {
    const toast = document.getElementById('successToast');
    toast.innerHTML = "✔ " + success;
    toast.classList.add('show');

    // Auto-hide after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}
</script>

</body>
</html>