<?php
include '../PHP/db.php';
$result = $conn->query("SELECT * FROM Students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>

<body>

<!-- UTD TOP BAR -->
<div class="top-bar">
    The University of Texas at Dallas
</div>

<!-- NAVBAR -->
<div class="navbar">
    <a href="/TUTORLINK/Dashboard.php">Home</a>
    <a href="/TUTORLINK/Students/StudentsDashboard.php">Students</a>
    <a href="/TUTORLINK/Tutors/TutorsDashboard.php">Tutors</a>
    <a href="/TUTORLINK/Lessons/LessonsDashboard.php">Lessons</a>
</div>

<div class="container">

<h2>Student List</h2>

<table>
<tr>
    <th>First Name</th>
    <th>Surname</th>
    <th>Age</th>
    <th>Email</th>
    <th>Phone</th>
    <th>NetID</th>
    <th>CometID</th>
    <th>Grad Year</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['FirstName']; ?></td>
    <td><?php echo $row['Surname']; ?></td>
    <td><?php echo $row['Age']; ?></td>
    <td><?php echo $row['Email']; ?></td>
    <td><?php echo $row['PhoneNumber']; ?></td>
    <td><?php echo $row['NetID']; ?></td>
    <td><?php echo $row['CometID']; ?></td>
    <td><?php echo $row['GradYear']; ?></td>
    <td class="action-col">

        <a href="/TUTORLINK/Students/EditStudent.php?id=<?php echo $row['StudentIndex']; ?>"
        class="action-link">
        Edit
        </a>

        <span class="divider">|</span>

        <a href="/TUTORLINK/PHP/deleteStudent.php?id=<?php echo $row['StudentIndex']; ?>"
        onclick="return confirm('Are you sure you want to delete this student?');"
        class="action-link delete">
        Delete
        </a>

    </td>
</tr>
<?php } ?>

</table>

</div>

<!-- SUCCESS TOAST -->
<div id="successToast" class="toast"></div>

<script>
const params = new URLSearchParams(window.location.search);
const success = params.get('success');

if (success) {
    const toast = document.getElementById('successToast');

    // Add checkmark + message
    toast.innerHTML = "✔️ " + success;

    // Show with animation
    toast.classList.add('show');

    // Fade out after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}
</script>

</body>
</html>