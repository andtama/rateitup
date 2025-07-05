<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM kuliner_places WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$place = $result->fetch_assoc();

if (!$place) {
    echo "Tempat tidak ditemukan.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    if (empty($name) || empty($location) || empty($description)) {
        $error = "Semua field wajib diisi.";
    } else {
        $stmt = $conn->prepare("UPDATE kuliner_places SET name = ?, location = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $location, $description, $id);
        if ($stmt->execute()) {
            header("Location: places.php");
            exit;
        } else {
            $error = "Gagal memperbarui tempat.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Tempat Kuliner</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title mb-4">✏️ Edit Tempat Kuliner</h3>

        <form method="POST">
          <div class="mb-3">
            <label for="name" class="form-label">Nama Tempat</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($place['name']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="location" class="form-label">Lokasi</label>
            <input type="text" name="location" id="location" class="form-control" value="<?= htmlspecialchars($place['location']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="4" required><?= htmlspecialchars($place['description']) ?></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Perbarui</button>
          <a href="places.php" class="btn btn-secondary ms-2">Batal</a>
        </form>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger mt-3"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="mt-3">
          <a href="places.php" class="btn btn-link text-decoration-none">← Kembali ke daftar</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
