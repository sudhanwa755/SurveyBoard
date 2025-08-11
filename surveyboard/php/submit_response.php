<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['survey_id'], $_POST['answers'])) {
    echo "<script>alert('Invalid request.'); window.location.href='../../take_survey.html';</script>";
    exit;
}

$survey_id = intval($_POST['survey_id']);
$answers = $_POST['answers'];

// Insert response record using submitted_at (not created_at)
$responseStmt = $conn->prepare("INSERT INTO responses (survey_id, submitted_at) VALUES (?, NOW())");
if (!$responseStmt) {
    die("Failed to prepare response insert: " . $conn->error);
}
$responseStmt->bind_param("i", $survey_id);
if (!$responseStmt->execute()) {
    die("Failed to execute response insert: " . $responseStmt->error);
}
$response_id = $conn->insert_id;
$responseStmt->close();

// Insert each answer into the answers table
$answerStmt = $conn->prepare("INSERT INTO answers (response_id, question_id, selected_option_id) VALUES (?, ?, ?)");
if (!$answerStmt) {
    die("Failed to prepare answer insert: " . $conn->error);
}

foreach ($answers as $question_id => $option_id) {
    $question_id = intval($question_id);
    $option_id = intval($option_id);
    $answerStmt->bind_param("iii", $response_id, $question_id, $option_id);
    if (!$answerStmt->execute()) {
        die("Failed to execute answer insert: " . $answerStmt->error);
    }
}
$answerStmt->close();
$conn->close();

// Redirect to thank you page
header("Location: /surveyboard/thank_you.html");
exit;
?>
