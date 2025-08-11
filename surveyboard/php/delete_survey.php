<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    die("Unauthorized access.");
}

$survey_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Check ownership
$stmt = $conn->prepare("SELECT id FROM surveys WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $survey_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Survey not found or access denied.");
}

// Begin transaction
$conn->begin_transaction();

try {
    // Delete options
    $opt_stmt = $conn->prepare("
        DELETE o FROM options o 
        JOIN questions q ON o.question_id = q.id 
        WHERE q.survey_id = ?
    ");
    $opt_stmt->bind_param("i", $survey_id);
    $opt_stmt->execute();

    // Delete answers
    $ans_stmt = $conn->prepare("
        DELETE FROM answers 
        WHERE response_id IN (SELECT id FROM responses WHERE survey_id = ?)
    ");
    $ans_stmt->bind_param("i", $survey_id);
    $ans_stmt->execute();

    // Delete responses
    $resp_stmt = $conn->prepare("DELETE FROM responses WHERE survey_id = ?");
    $resp_stmt->bind_param("i", $survey_id);
    $resp_stmt->execute();

    // Delete questions
    $ques_stmt = $conn->prepare("DELETE FROM questions WHERE survey_id = ?");
    $ques_stmt->bind_param("i", $survey_id);
    $ques_stmt->execute();

    // Delete survey
    $surv_stmt = $conn->prepare("DELETE FROM surveys WHERE id = ?");
    $surv_stmt->bind_param("i", $survey_id);
    $surv_stmt->execute();

    // Commit if all goes well
    $conn->commit();

    header("Location: ../dashboard.php");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    die("Failed to delete survey: " . $e->getMessage());
}
?>
