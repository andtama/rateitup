<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT comments.*, users.username, kuliner_places.name AS place_name
        FROM comments
        JOIN users ON comments.user_id = users.id
        JOIN reviews ON comments.review_id = reviews.id
        JOIN kuliner_places ON reviews.place_id = kuliner_places.id
        WHERE comments.status = 'pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Moderasi Komentar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<div class="container py-4">

<h2 class="mb-4">📝 Moderasi Komentar</h2>

<?php while($c = $result->fetch_assoc()): ?>
  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title">
        <?= htmlspecialchars($c['username']) ?> di <?= htmlspecialchars($c['place_name']) ?>
      </h5>
      <p class="card-text">
        <?= nl2br(htmlspecialchars($c['comment_text'])) ?>
      </p>
      <a href="proses_moderasi.php?id=<?= $c['id'] ?>&action=approve" class="btn btn-success btn-sm me-2">
        ✅ Setujui
      </a>
      <a href="proses_moderasi.php?id=<?= $c['id'] ?>&action=reject" class="btn btn-danger btn-sm">
        ❌ Tolak
      </a>
    </div>
  </div>
<?php endwhile; ?>
