<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'config/db.php';

$name = $_POST['name'];
$location = $_POST['location'];
$description = $_POST['description'];

$imageName = null;
if (!empty($_FILES['image']['name'])) {
    $targetDir = "uploads/";
    $uniqueName = uniqid() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $uniqueName;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $imageName = $uniqueName;
    }
}

$stmt = $conn->prepare("INSERT INTO kuliner_places (name, location, description, image) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $location, $description, $imageName);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: index.php");
} else {
    echo "Gagal menambahkan tempat: " . $conn->error;
}
exit;
?>
