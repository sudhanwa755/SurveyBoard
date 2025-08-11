<?php
session_start();
include 'php/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT s.id, s.title, s.description, s.code, s.created_at, 
    (SELECT COUNT(*) FROM responses r WHERE r.survey_id = s.id) AS response_count
    FROM surveys s 
    WHERE s.user_id = ? 
    ORDER BY s.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$surveys = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - SurveyBoard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #f4f7fb;
      --text: #212529;
      --card-bg: #fff;
      --dark-bg: #181a1b;
      --dark-card: #252a2f;
      --dark-text: #f1f1f1;
    }

    html {
      transition: background-color 0.4s ease, color 0.4s ease;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--bg);
      color: var(--text);
    }

    .dark-mode body {
      background-color: var(--dark-bg);
      color: var(--dark-text);
    }

    .navbar {
      background-color: #343a40;
      padding: 0.75rem 1rem;
    }

    .navbar-brand {
      font-weight: 600;
      font-size: 1.3rem;
      color: #ffffff !important;
    }

    .dashboard-header {
      margin-top: 30px;
      margin-bottom: 20px;
      text-align: center;
      animation: fadeIn 1s ease;
    }

    .survey-card {
      background-color: var(--card-bg);
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 6px 14px rgba(0,0,0,0.06);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      min-height: 270px;
    }

    .survey-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.12);
    }

    .dark-mode .survey-card {
      background-color: var(--dark-card);
      color: var(--dark-text);
    }

    .survey-code {
      background-color: #e9ecef;
      padding: 5px 10px;
      border-radius: 6px;
      font-weight: 600;
    }

    .dark-mode .survey-code {
      background-color: #444;
    }

    .btn-copy {
      font-size: 0.75rem;
      padding: 3px 6px;
    }

    .card-actions {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    @media (max-width: 576px) {
      .card-actions {
        flex-direction: column;
      }
    }

    .theme-toggle {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 24px;
    }

    .theme-toggle input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      border-radius: 34px;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      border-radius: 50%;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:checked + .slider:before {
      transform: translateX(26px);
    }

    .switch {
      display: flex;
      align-items: center;
      gap: 8px;
      color: white;
      margin-left: auto;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }

    .toast {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #0d6efd;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.4s ease;
      z-index: 9999;
    }

    .toast.show {
      opacity: 1;
      pointer-events: all;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">📊 SurveyBoard</a>
    <label class="switch">
      <span>🌓</span>
      <div class="theme-toggle">
        <input type="checkbox" id="modeSwitch" onclick="toggleTheme()">
        <span class="slider"></span>
      </div>
    </label>
  </div>
</nav>

<div class="container">
  <div class="dashboard-header">
    <h2>Welcome back, <?= htmlspecialchars($_SESSION['user_name']) ?> 🎉</h2>
     <p class="fw-semibold" style="color: #007bff;">Your survey management hub</p>
  </div>

  <div class="d-flex justify-content-between flex-wrap mb-4">
    <a href="create_form.html" class="btn btn-primary mb-2">➕ Create New Survey</a>
    <a href="php/logout.php" class="btn btn-outline-danger mb-2">🚪 Logout</a>
  </div>

  <?php if ($surveys->num_rows > 0): ?>
    <div class="row g-4">
      <?php while ($survey = $surveys->fetch_assoc()): ?>
        <div class="col-md-6 col-lg-4">
          <div class="survey-card">
            <h5>📌 <?= htmlspecialchars($survey['title']) ?></h5>
            <p><?= htmlspecialchars($survey['description']) ?></p>
            <p><strong>Code:</strong> 
              <span class="survey-code" id="code-<?= $survey['id'] ?>"><?= $survey['code'] ?></span>
              <button class="btn btn-sm btn-outline-secondary btn-copy" title="Copy Code"
                onclick="copyCode('<?= $survey['code'] ?>')">📋</button>
            </p>
            <p><strong>Created:</strong> <?= htmlspecialchars($survey['created_at']) ?></p>
            <p><strong>Responses:</strong> <?= htmlspecialchars($survey['response_count']) ?></p>
            <div class="card-actions">
              <a href="php/results.php?code=<?= urlencode($survey['code']) ?>" class="btn btn-sm btn-success w-100">📊 View Results</a>
              <button class="btn btn-sm btn-outline-danger w-100" onclick="confirmDelete(<?= (int)$survey['id'] ?>)">🗑️ Delete</button>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center mt-4">You haven't created any surveys yet.</div>
  <?php endif; ?>
</div>

<div class="toast" id="copyToast">✅ Code copied to clipboard!</div>

<script>
  function copyCode(code) {
    navigator.clipboard.writeText(code).then(() => {
      const toast = document.getElementById("copyToast");
      toast.classList.add("show");
      setTimeout(() => {
        toast.classList.remove("show");
      }, 2000);
    });
  }

  function confirmDelete(surveyId) {
    if (confirm("Are you sure you want to delete this survey?")) {
      window.location.href = "php/delete_survey.php?id=" + surveyId;
    }
  }

  function toggleTheme() {
    const root = document.documentElement;
    const isDark = root.classList.toggle("dark-mode");
    localStorage.setItem("theme", isDark ? "dark" : "light");

    document.getElementById("modeSwitch").checked = isDark;
  }

  window.onload = function () {
    const isDark = localStorage.getItem("theme") === "dark";
    if (isDark) {
      document.documentElement.classList.add("dark-mode");
      document.getElementById("modeSwitch").checked = true;
    }
  };
</script>

</body>
</html>
