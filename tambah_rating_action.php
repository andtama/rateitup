<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include '../config/db.php';

$user_id = $_SESSION['user_id'];
$place_id = $_POST['place_id'];
$rating = intval($_POST['rating']);

$check = $conn->query("SELECT * FROM ratings WHERE user_id = $user_id AND place_id = $place_id");
if ($check->num_rows > 0) {

    $sql = "UPDATE ratings SET rating = $rating WHERE user_id = $user_id AND place_id = $place_id";
} else {

    $sql = "INSERT INTO ratings (user_id, place_id, rating) VALUES ($user_id, $place_id, $rating)";
}

if ($conn->query($sql)) {
    header("Location: ../place.php?id=" . $place_id);
} else {
    echo "Gagal menyimpan rating: " . $conn->error;
}
?>

