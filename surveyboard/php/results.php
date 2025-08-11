<?php
include 'db.php';

$code = isset($_GET['code']) ? strtoupper(trim($_GET['code'])) : '';

if (empty($code)) {
    echo "<script>alert('No survey code provided.'); window.location.href='../dashboard.php';</script>";
    exit;
}

$query = $conn->prepare("SELECT id, title FROM surveys WHERE code = ?");
if (!$query) {
    die("Query error: " . $conn->error);
}
$query->bind_param("s", $code);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Survey not found'); window.location.href='../dashboard.php';</script>";
    exit;
}

$survey = $result->fetch_assoc();
$survey_id = $survey['id'];

// Fetch questions and options with response counts
$questions = [];
$qStmt = $conn->prepare("SELECT id, question_text FROM questions WHERE survey_id = ?");
$qStmt->bind_param("i", $survey_id);
$qStmt->execute();
$qResult = $qStmt->get_result();

while ($q = $qResult->fetch_assoc()) {
    $q_id = $q['id'];
    $q['options'] = [];

    $optStmt = $conn->prepare("
        SELECT o.option_text, COUNT(a.selected_option_id) AS total
        FROM options o
        LEFT JOIN answers a ON o.id = a.selected_option_id
        WHERE o.question_id = ?
        GROUP BY o.id
    ");
    $optStmt->bind_param("i", $q_id);
    $optStmt->execute();
    $optResult = $optStmt->get_result();

    while ($opt = $optResult->fetch_assoc()) {
        $q['options'][] = $opt;
    }

    $questions[] = $q;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Survey Results - <?= htmlspecialchars($survey['title']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Theme -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/theme.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Apply Theme Early -->
  <script>
    if (localStorage.getItem('theme') === 'dark') {
      document.documentElement.classList.add('dark-mode');
    }
  </script>

  <style>
    .chart-container {
      position: relative;
      height: 300px;
      width: 100%;
    }
  </style>
</head>
<body>

<div class="container mt-4">
  <button class="btn btn-sm btn-outline-secondary toggle-btn" onclick="toggleMode()">🌓 Toggle Mode</button>

  <h3 class="mb-3">📊 Results: <?= htmlspecialchars($survey['title']) ?></h3>
  <a href="../dashboard.php" class="btn btn-secondary mb-4">⬅ Back to Dashboard</a>

  <?php if (empty($questions)): ?>
    <p class="text-muted">This survey has no questions yet.</p>
  <?php else: ?>
    <?php foreach ($questions as $index => $q): 
      $chartId = "chart_" . $index;
      $labels = [];
      $data = [];

      foreach ($q['options'] as $opt) {
          $labels[] = $opt['option_text'];
          $data[] = (int)$opt['total'];
      }

      $totalResponses = array_sum($data);
    ?>
    <div class="mb-5 card p-4">
      <h5><?= ($index + 1) . ". " . htmlspecialchars($q['question_text']) ?></h5>

      <?php if ($totalResponses === 0): ?>
        <p class="text-muted">There are no responses at this time.</p>
      <?php else: ?>
        <div class="chart-container">
          <canvas id="<?= $chartId ?>"></canvas>
        </div>
        <script>
          const isDark = document.documentElement.classList.contains('dark-mode');
          new Chart(document.getElementById('<?= $chartId ?>').getContext('2d'), {
            type: 'bar',
            data: {
              labels: <?= json_encode($labels) ?>,
              datasets: [{
                label: 'Responses',
                data: <?= json_encode($data) ?>,
                backgroundColor: isDark ? '#00c4cc' : '#4e79a7'
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                x: {
                  ticks: {
                    color: isDark ? '#fff' : '#000'
                  }
                },
                y: {
                  beginAtZero: true,
                  ticks: {
                    color: isDark ? '#fff' : '#000',
                    precision: 0
                  }
                }
              },
              plugins: {
                legend: {
                  labels: {
                    color: isDark ? '#fff' : '#000'
                  }
                }
              }
            }
          });
        </script>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<script src="../js/theme.js"></script>
</body>
</html>
