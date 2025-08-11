<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized.");
}

$title = $_POST['title'];
$description = $_POST['description'];
$questions = $_POST['questions'];
$user_id = $_SESSION['user_id'];
$code = strtoupper(substr(md5(time() . rand()), 0, 6));

// Insert survey
$stmt = $conn->prepare("INSERT INTO surveys (user_id, title, description, code) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $user_id, $title, $description, $code);
if (!$stmt->execute()) {
    die("Failed to create survey: " . $stmt->error);
}
$survey_id = $stmt->insert_id;

// Loop through questions
for ($i = 0; $i < count($questions); $i++) {
    $qText = $questions[$i];

    $q_stmt = $conn->prepare("INSERT INTO questions (survey_id, question_text) VALUES (?, ?)");
    $q_stmt->bind_param("is", $survey_id, $qText);
    if (!$q_stmt->execute()) {
        die("Failed to insert question: " . $q_stmt->error);
    }
    $question_id = $q_stmt->insert_id;

    $optionKey = "options" . $i;
    if (isset($_POST[$optionKey])) {
        foreach ($_POST[$optionKey] as $opt) {
            $opt_stmt = $conn->prepare("INSERT INTO options (question_id, option_text) VALUES (?, ?)");
            $opt_stmt->bind_param("is", $question_id, $opt);
            if (!$opt_stmt->execute()) {
                die("Failed to insert option: " . $opt_stmt->error);
            }
        }
    } else {
        die("Missing options for question $i.");
    }
}

// Success message
echo "<script>alert('Survey created! Your code is: $code'); window.location.href='../dashboard.php';</script>";
?>
