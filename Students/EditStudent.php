<?php
// =========================================
// DATABASE CONNECTION
// =========================================
include '../PHP/db.php';

// =========================================
// FETCH STUDENT BY ID
// =========================================
$id = $_GET['id'];

$result = $conn->query("SELECT * FROM Students WHERE StudentIndex = $id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="/TUTORLINK/CSS/styles.css">
</head>

<body>

<!-- TOP BAR -->
<div class="top-bar">The University of Texas at Dallas</div>

<div class="container">

<h2>Edit Student</h2>

<!-- =========================================
     EDIT FORM
     Sends updated data to backend
========================================= -->
<form action="/TUTORLINK/PHP/updateStudent.php" method="post">

<!-- Hidden ID for update query -->
<input type="hidden" name="id" value="<?php echo $row['StudentIndex']; ?>">

<!-- Editable fields -->
<label>First Name</label>
<input type="text" name="firstName" value="<?php echo $row['FirstName']; ?>" required>

<label>Surname</label>
<input type="text" name="surname" value="<?php echo $row['Surname']; ?>">

<label>Age</label>
<input type="number" name="age" value="<?php echo $row['Age']; ?>" required>

<label>Phone</label>
<input type="text" name="phone" value="<?php echo $row['PhoneNumber']; ?>">

<label>Email</label>
<input type="email" name="email" value="<?php echo $row['Email']; ?>">

<label>Graduation Year</label>
<input type="number" name="gradyear" value="<?php echo $row['GradYear']; ?>">

<!-- =========================================
     READ-ONLY FIELDS (IDENTIFIERS)
     Cannot be changed after creation
========================================= -->
<label>NetID</label>
<input type="text" value="<?php echo $row['NetID']; ?>" readonly>

<label>Comet ID</label>
<input type="text" value="<?php echo $row['CometID']; ?>" readonly>

<button type="submit">Update Student</button>

</form>

</div>

</body>
</html>