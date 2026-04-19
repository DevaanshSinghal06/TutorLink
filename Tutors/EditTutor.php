<?php
include '../PHP/db.php';

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM Tutors WHERE TutorIndex = $id");
$row = $result->fetch_assoc();
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

<form action="/TUTORLINK/PHP/updateTutor.php" method="post">

<input type="hidden" name="id" value="<?php echo $row['TutorIndex']; ?>">

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

<label>Tutor Type</label>
<select name="tutorType">
    <option value="UTD" <?php if ($row['TutorType']=="UTD") echo "selected"; ?>>UTD</option>
    <option value="External" <?php if ($row['TutorType']=="External") echo "selected"; ?>>External</option>
</select>

<!-- UTD Fields -->
<label>NetID</label>
<input type="text" name="netid" value="<?php echo $row['NetID']; ?>">

<label>Comet ID</label>
<input type="text" name="cometid" value="<?php echo $row['CometID']; ?>">

<!-- External Fields -->
<label>Tutor ID</label>
<input type="text" name="tutorid" value="<?php echo $row['TutorID']; ?>">

<label>Company</label>
<input type="text" name="company" value="<?php echo $row['Company']; ?>">

<label>Other</label>
<input type="text" name="other" value="<?php echo $row['Other']; ?>">

<button type="submit">Update Tutor</button>

</form>

</div>

</body>
</html>