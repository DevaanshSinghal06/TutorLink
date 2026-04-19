<?php
include '../PHP/db.php';

$id = $_GET['id'];
$tutor = $row['TutorIndex'];

$result = $conn->query("SELECT * FROM Lessons WHERE LessonID = $id");
$row = $result->fetch_assoc();

// fetch locations
$locations = $conn->query("SELECT * FROM Locations");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Lesson</title>
    <link rel="stylesheet" href="/TUTORLINK/CSS/styles.css">
</head>

<body>

<div class="container">
<h2>Edit Lesson (Reschedule)</h2>

<form action="/TUTORLINK/PHP/updateLesson.php" method="post">

<input type="hidden" name="id" value="<?php echo $row['LessonID']; ?>">

<label>Date</label>
<input type="date" name="lessonDate" value="<?php echo $row['LessonDate']; ?>" required>
<button type="button" onclick="loadAvailability()">Check Availability</button>
<div id="timeSlots"></div>

<label>Start Time</label>
<input type="time" name="startTime" value="<?php echo $row['StartTime']; ?>" required>

<label>Duration (minutes)</label>
<input type="number" name="duration" value="<?php echo $row['Duration']; ?>" required>

<label>Location</label>
<select name="locationIndex">
<?php while($loc = $locations->fetch_assoc()): ?>
    <option value="<?php echo $loc['LocationIndex']; ?>"
    <?php if ($loc['LocationIndex'] == $row['LocationIndex']) echo "selected"; ?>>
    <?php echo $loc['BuildingID'] . " " . $loc['RoomNumber']; ?>
    </option>
<?php endwhile; ?>
</select>

<button type="submit">Update Lesson</button>

</form>

</div>

function loadAvailability() {
    const tutor = <?php echo $tutor; ?>;
    const date = document.querySelector('[name="lessonDate"]').value;

    fetch(`/TUTORLINK/PHP/getAvailability.php?tutor=${tutor}&date=${date}`)
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById("timeSlots");
            container.innerHTML = "";

            data.forEach(time => {
                let btn = document.createElement("button");
                btn.innerText = time;

                btn.onclick = () => {
                    document.querySelector('[name="startTime"]').value = time;
                };

                container.appendChild(btn);
            });
        });
}

</body>
</html>