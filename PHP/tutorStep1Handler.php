<?php
// =========================================
// HANDLE STEP 1 → STEP 2 REDIRECT
// =========================================

// Get selected tutor type from Step 1 form
$tutorType = $_POST['tutorType'];

// Build query string with ALL Step 1 form data
// This allows Step 2 to reuse the data via URL params
$query = http_build_query($_POST);

// =========================================
// ROUTE TO CORRECT STEP 2 PAGE
// =========================================
if ($tutorType == "UTD") {
    header("Location: /TUTORLINK/Tutors/AddTutorStep2UTD.php?$query");

} else if ($tutorType == "External") {
    header("Location: /TUTORLINK/Tutors/AddTutorStep2External.php?$query");

} else {
    // Fallback if user didn't select type
    header("Location: /TUTORLINK/Tutors/AddTutorStep1.html?error=Select tutor type");
}

exit();
?>