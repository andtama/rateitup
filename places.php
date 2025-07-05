<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM kuliner_places ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Tempat Kuliner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2 class="mb-4">Manajemen Tempat Kuliner</h2>

        <a href="tambah_place.php" class="btn btn-primary mb-3">+ Tambah Tempat</a>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Tempat</th>
                    <th>Lokasi</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $result = $conn->query("SELECT * FROM kuliner_places");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['description']}</td>
                            <td>
                                <a href='edit_place.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                                <a href='hapus_place.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Hapus data ini?')\">Hapus</a>
                            </td>
                          </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
