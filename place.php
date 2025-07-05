<?php
session_start();
include 'config/db.php';

if (!isset($_GET['id'])) {
    echo "Tempat tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']); 
$sql = "SELECT * FROM kuliner_places WHERE id = $id";
$result = $conn->query($sql);
$place = $result->fetch_assoc();

if (!$place) {
    echo "Tempat tidak ditemukan di database.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($place['name']) ?> - Rate It Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="card mb-4">
        <div class="card-body">
            <?php if (!empty($place['image'])): ?>
                <img src="../uploads/<?= htmlspecialchars($place['image']) ?>" class="img-fluid mb-3 rounded" alt="<?= htmlspecialchars($place['name']) ?>" style="max-height: 300px; object-fit: cover;">
            <?php endif; ?>

            <h2 class="card-title"><?= htmlspecialchars($place['name']) ?></h2>
            <p class="card-text"><strong>Lokasi:</strong> <?= htmlspecialchars($place['location']) ?></p>
            <p class="card-text"><strong>Deskripsi:</strong> <?= htmlspecialchars($place['description']) ?></p>

            <?php
            $rating_sql = "SELECT AVG(rating) as avg_rating FROM ratings WHERE place_id = $id";
            $rating_result = $conn->query($rating_sql);
            $rating = $rating_result->fetch_assoc()['avg_rating'];

            if ($rating) {
                echo "<p class='card-text'><strong>Rating Rata-rata:</strong> " . str_repeat('⭐', round($rating)) . " (" . round($rating, 1) . "/5)</p>";
            } else {
                echo "<p class='text-muted'>Belum ada rating.</p>";
            }
            ?>
        </div>
    </div>

    <h4 class="mb-3">Review Pengguna</h4>
    <?php
    $review_sql = "
        SELECT reviews.*, users.username 
        FROM reviews 
        JOIN users ON reviews.user_id = users.id 
        WHERE place_id = $id 
        ORDER BY created_at DESC
    ";
    $review_result = $conn->query($review_sql);
    while ($r = $review_result->fetch_assoc()) {
        echo "<div class='card mb-2'>
                <div class='card-body'>
                    <h6 class='card-subtitle mb-1 text-muted'>" . htmlspecialchars($r['username']) . "</h6>
                    <p class='card-text'>" . htmlspecialchars($r['review_text']) . "</p>
                </div>
              </div>";
    }
    ?>

    <?php if (isset($_SESSION['user_id'])): ?>
    <form method="POST" action="actions/tambah_review_action.php" class="mt-4">
        <input type="hidden" name="place_id" value="<?= $id ?>">
        <div class="mb-3">
            <label class="form-label">Tulis Review</label>
            <textarea name="review_text" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Review</button>
    </form>
    <?php else: ?>
        <div class="alert alert-warning mt-4">Silakan <a href="login.php">login</a> untuk menulis review.</div>
    <?php endif; ?>

    <hr class="my-5">

    <h4 class="mb-3">Komentar</h4>
    <?php
    $comment_sql = "SELECT comments.*, users.username 
                    FROM comments
                    JOIN users ON comments.user_id = users.id
                    WHERE comments.status = 'approved'
                    AND comments.review_id IN (
                        SELECT id FROM reviews WHERE place_id = $id
                    )
                    ORDER BY comments.created_at DESC";

    $comment_result = $conn->query($comment_sql);
    while ($c = $comment_result->fetch_assoc()) {
        echo "<div class='card mb-2'>
                <div class='card-body'>
                    <h6 class='card-subtitle mb-1 text-muted'>" . htmlspecialchars($c['username']) . "</h6>
                    <p class='card-text'>" . htmlspecialchars($c['comment_text']) . "</p>
                </div>
              </div>";
    }
    ?>

    <?php if (isset($_SESSION['user_id'])): ?>
    <form method="POST" action="actions/tambah_komentar_action.php" class="mt-4">
        <input type="hidden" name="place_id" value="<?= $id ?>">
        <div class="mb-3">
            <label class="form-label">Pilih Review</label>
            <select name="review_id" class="form-select" required>
                <?php
                $review_list_sql = "SELECT id FROM reviews WHERE place_id = $id";
                $review_list_result = $conn->query($review_list_sql);
                while ($r = $review_list_result->fetch_assoc()) {
                    echo "<option value='" . $r['id'] . "'>Review #" . $r['id'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Komentar</label>
            <textarea name="comment_text" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Kirim Komentar</button>
    </form>
    <?php else: ?>
        <div class="alert alert-warning mt-4">Silakan <a href="login.php">login</a> untuk menulis komentar.</div>
    <?php endif; ?>

    <hr class="my-5">

    <?php if (isset($_SESSION['user_id'])): ?>
    <form method="POST" action="actions/tambah_rating_action.php" class="mt-4">
        <input type="hidden" name="place_id" value="<?= $id ?>">
        <div class="mb-3">
            <label class="form-label">Beri Rating</label>
            <select name="rating" class="form-select" required>
                <option value="">Pilih rating...</option>
                <option value="1">⭐</option>
                <option value="2">⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Kirim Rating</button>
    </form>
    <?php else: ?>
        <div class="alert alert-warning mt-4">Silakan <a href="login.php">login</a> untuk memberi rating.</div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

