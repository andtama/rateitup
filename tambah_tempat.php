<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Tempat Kuliner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Tambah Tempat Kuliner</h2>

        <form action="tambah_place_action.php" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 500px;">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Tempat</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Warung Sate Pak Daman" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" name="location" id="location" class="form-control" placeholder="Contoh: Jl. Sumbing No.1, Blora" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control" rows="4" placeholder="Ceritakan keunikan atau kelezatan tempat ini..."></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Upload Gambar</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">Tambah Tempat</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
