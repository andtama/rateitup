<?php
include 'config/db.php';

$name = $_POST['name'];
$location = $_POST['location'];
$description = $_POST['description'];

$imageName = null;
if (!empty($_FILES['image']['name'])) {
    $targetDir = "../uploads/";
    $imageName = uniqid() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $imageName;

    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
}

$stmt = $conn->prepare("INSERT INTO kuliner_places (name, location, description, image) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $location, $description, $imageName);
$stmt->execute();

header("Location: places.php");
exit;
?>
