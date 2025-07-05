<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand">Admin Panel</span>
            <div class="d-flex">
                <span class="navbar-text me-3 text-white">
                    Selamat datang, <?= htmlspecialchars($_SESSION['admin_username']) ?>
                </span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <h3 class="mb-4">Menu Admin</h3>
        <div class="list-group">
            <a href="moderasi_komentar.php" class="list-group-item list-group-item-action">📝 Moderasi Komentar</a>
            <a href="places.php" class="list-group-item list-group-item-action">📍 Manajemen Tempat Kuliner</a>
            <a href="logout.php" class="list-group-item list-group-item-action text-danger">🚪 Logout</a>
        </div>
    </div>

</body>
</html>
