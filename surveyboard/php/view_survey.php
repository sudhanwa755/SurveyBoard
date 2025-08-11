<?php
include 'db.php';

if (!isset($_GET['code']) || empty(trim($_GET['code']))) {
    echo "<script>alert('No survey code provided.'); window.location.href='../../take_survey.html';</script>";
    exit;
}

$code = strtoupper(trim($_GET['code']));
$query = $conn->prepare("SELECT id, title, description FROM surveys WHERE code = ?");
$query->bind_param("s", $code);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Invalid survey code.'); window.location.href='../../take_survey.html';</script>";
    exit;
}

$survey = $result->fetch_assoc();
$survey_id = $survey['id'];

$questions = [];
$questionStmt = $conn->prepare("SELECT id, question_text FROM questions WHERE survey_id = ?");
$questionStmt->bind_param("i", $survey_id);
$questionStmt->execute();
$questionResult = $questionStmt->get_result();

while ($q = $questionResult->fetch_assoc()) {
    $q_id = $q['id'];
    $q['options'] = [];

    $optionStmt = $conn->prepare("SELECT id, option_text FROM options WHERE question_id = ?");
    $optionStmt->bind_param("i", $q_id);
    $optionStmt->execute();
    $optionResult = $optionStmt->get_result();

    while ($opt = $optionResult->fetch_assoc()) {
        $q['options'][] = $opt;
    }

    $questions[] = $q;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($survey['title']); ?> - Survey</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Apply dark mode early -->
  <script>
    if (localStorage.getItem('theme') === 'dark') {
      document.documentElement.classList.add('dark-mode');
    }
  </script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
    body {
      background-color: #f8f9fa;
      color: #212529;
      transition: background-color 0.3s, color 0.3s;
    }

    .survey-container {
      max-width: 800px;
      margin: 50px auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .question-title {
      font-weight: bold;
    }

    .btn-toggle {
      position: fixed;
      top: 15px;
      right: 15px;
      z-index: 1000;
    }

    .dark-mode body {
      background-color: #121212;
      color: #f1f1f1;
    }

    .dark-mode .survey-container {
      background-color: #1e1e1e;
      color: #f1f1f1;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.05);
    }

    .dark-mode input[type="radio"] {
      background-color: #2a2a2a;
    }

    .dark-mode .form-check-label {
      color: #f1f1f1;
    }

    .dark-mode .btn-primary {
      background-color: #0d6efd;
      border-color: #0d6efd;
    }

    .dark-mode .btn-secondary {
      background-color: #6c757d;
      border-color: #6c757d;
    }

    .tagline {
      color: #007bff;
      font-weight: 500;
    }
  </style>
</head>
<body>

  <button onclick="toggleMode()" class="btn btn-sm btn-outline-secondary btn-toggle">🌓 Toggle Mode</button>

  <div class="survey-container">
    <h3><?= htmlspecialchars($survey['title']); ?></h3>
    <p class="tagline">Your trusted platform for easy surveys</p>
    <p><?= htmlspecialchars($survey['description']); ?></p>

    <?php if (empty($questions)): ?>
      <p class="text-muted">This survey has no questions yet.</p>
      <a href="../../take_survey.html" class="btn btn-secondary">⬅ Back</a>
    <?php else: ?>
      <form method="POST" action="submit_response.php">
        <input type="hidden" name="survey_id" value="<?= $survey_id; ?>">

        <?php foreach ($questions as $index => $question): ?>
          <div class="mb-4">
            <p class="question-title">Q<?= $index + 1 ?>. <?= htmlspecialchars($question['question_text']); ?></p>

            <?php if (empty($question['options'])): ?>
              <p class="text-danger">⚠ This question has no options.</p>
            <?php else: ?>
              <?php foreach ($question['options'] as $option): ?>
                <div class="form-check">
                  <input class="form-check-input" type="radio"
                         name="answers[<?= $question['id']; ?>]"
                         value="<?= $option['id']; ?>" required>
                  <label class="form-check-label">
                    <?= htmlspecialchars($option['option_text']); ?>
                  </label>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary">Submit Survey</button>
      </form>
    <?php endif; ?>
  </div>

  <script>
    function toggleMode() {
      const root = document.documentElement;
      root.classList.toggle('dark-mode');
      localStorage.setItem('theme', root.classList.contains('dark-mode') ? 'dark' : 'light');
    }
  </script>
</body>
</html>
