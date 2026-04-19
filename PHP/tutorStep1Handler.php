<?php

$tutorType = $_POST['tutorType'];

// Build query string with Step 1 data
$query = http_build_query($_POST);

if ($tutorType == "UTD") {
    header("Location: /TUTORLINK/Tutors/AddTutorStep2UTD.php?$query");
} else if ($tutorType == "External") {
    header("Location: /TUTORLINK/Tutors/AddTutorStep2External.php?$query");
} else {
    header("Location: /TUTORLINK/Tutors/AddTutorStep1.html?error=Select tutor type");
}

exit();
?>