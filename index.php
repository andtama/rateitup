<?php
include 'config/db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Tempat Kuliner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4 text-center">Daftar Tempat Kuliner</h1>

        <div class="d-flex justify-content-end mb-4">
            <a href="tambah_tempat.php" class="btn btn-success">+ Tambah Tempat</a>
        </div>

        <div class="row">
            <?php
            $sql = "SELECT * FROM kuliner_places ORDER BY id DESC";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($row['image'])): ?>
                            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="place.php?id=<?= $row['id'] ?>" class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($row['name']) ?>
                                </a>
                            </h5>
                            <p class="card-text"><?= htmlspecialchars($row['location']) ?></p>
                        </div>
                        <div class="card-footer text-end">
                            <a href="place.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
