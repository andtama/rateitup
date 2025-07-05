<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: places.php");
    exit;
}

$id = $_GET['id'];

$result = $conn->query("SELECT image FROM kuliner_places WHERE id = '$id'");
if ($result && $row = $result->fetch_assoc()) {
    $imagePath = "../uploads/" . $row['image'];
    if (!empty($row['image']) && file_exists($imagePath)) {
        unlink($imagePath); 
    }
}

$conn->query("DELETE FROM reviews WHERE place_id = '$id'");

$stmt = $conn->prepare("DELETE FROM kuliner_places WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: places.php");
    exit;
} else {
    echo "<script>alert('Gagal menghapus tempat: " . $stmt->error . "'); window.location.href='places.php';</script>";
}
?>
