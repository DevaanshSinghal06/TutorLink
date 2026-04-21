<?php
include '../PHP/db.php';

// =========================================
// GET LESSON DATA BY ID
// =========================================
$id = $_GET['id'];

$result = $conn->query("SELECT * FROM Lessons WHERE LessonID = $id");
$row = $result->fetch_assoc();

// Tutor needed for availability API
$tutor = $row['TutorIndex'];

// Fetch all locations
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

<!-- Date -->
<label>Date</label>
<input type="date" name="lessonDate" value="<?php echo $row['LessonDate']; ?>" required>

<!-- Availability Button -->
<button type="button" onclick="loadAvailability()">Check Availability</button>
<div id="timeSlots"></div>

<!-- Start Time -->
<label>Start Time</label>
<input type="time" name="startTime" value="<?php echo $row['StartTime']; ?>" required>

<!-- Duration -->
<label>Duration (minutes)</label>
<input type="number" name="duration" value="<?php echo $row['Duration']; ?>" required>

<!-- Location -->
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

<script>
// =========================================
// LOAD AVAILABLE TIME SLOTS
// =========================================
function loadAvailability() {
    const tutor = <?php echo $tutor; ?>;
    const date = document.querySelector('[name="lessonDate"]').value;
    const location = document.querySelector('[name="locationIndex"]').value;

    let duration = document.querySelector('[name="duration"]').value;
    if (!duration) duration = 30;

    if (!date) {
        alert("Please select a date first.");
        return;
    }

    fetch(`/TUTORLINK/PHP/getAvailability.php?tutor=${tutor}&date=${date}&location=${location}&duration=${duration}`)
        .then(res => res.json())
        .then(slots => {

            const container = document.getElementById("timeSlots");

            if (slots.length === 0) {
                container.innerHTML = "<div class='availability-box'>No availability</div>";
                return;
            }

            let html = `
            <div class="availability-box">
                <strong>Available Times (${duration} min sessions):</strong><br><br>
                <div class="time-grid">
            `;

            slots.forEach(time => {
                html += `<button type="button" class="time-slot" onclick="selectTime('${time}')">${time}</button>`;
            });

            html += `</div></div>`;

            container.innerHTML = html;
        });
}

// =========================================
// SELECT TIME SLOT
// =========================================
function selectTime(time) {
    document.querySelector('[name="startTime"]').value = time;

    document.querySelectorAll('.time-slot').forEach(btn => {
        btn.classList.remove('selected');
    });

    event.target.classList.add('selected');
}
</script>

</body>
</html>