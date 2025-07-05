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

$id = intval($_GET['id']);

$sql = "SELECT * FROM kuliner_places WHERE id = $id";
$result = $conn->query($sql);
$place = $result->fetch_assoc();

if (!$place) {
    echo "Tempat tidak ditemukan.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE kuliner_places SET name=?, location=?, description=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $location, $description, $id);

    if ($stmt->execute()) {
        header("Location: places.php");
        exit;
    } else {
        $error = "Gagal mengupdate tempat.";
    }
}
?>

<h2>Edit Tempat Kuliner</h2>

<form method="POST">
    <label>Nama Tempat:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($place['name']) ?>" required><br><br>

    <label>Lokasi:</label><br>
    <input type="text" name="location" value="<?= htmlspecialchars($place['location']) ?>" required><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="description" required><?= htmlspecialchars($place['description']) ?></textarea><br><br>

    <button type="submit">Update</button>
</form>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<a href="places.php">← Kembali ke daftar</a>
