<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$result = $conn->query("
    SELECT s.*, COUNT(r.id) AS responses
    FROM surveys s
    LEFT JOIN responses r ON s.id = r.survey_id
    WHERE s.user_id = $user_id
    GROUP BY s.id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Submitted Surveys - SurveyBoard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f5f7fa;
    }
    .container {
      margin-top: 60px;
    }
    .table {
      background-color: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    th, td {
      vertical-align: middle !important;
    }
  </style>
</head>
<body>

<div class="container">
  <h3 class="mb-4">📋 My Submitted Surveys</h3>

  <?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered table-hover">
      <thead class="thead-dark">
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Survey Code</th>
          <th>Responses</th>
          <th>View Results</th>
        </tr>
      </thead>
      <tbody>
        <?php $index = 1; ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $index++; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['code']); ?></td>
            <td><?php echo $row['responses']; ?></td>
            <td>
              <a href="results.php?code=<?php echo urlencode($row['code']); ?>" class="btn btn-primary btn-sm">
                📊 View Results
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info">You haven't created any surveys yet.</div>
  <?php endif; ?>
</div>

</body>
</html>
