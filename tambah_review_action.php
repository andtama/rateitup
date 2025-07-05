<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include '../config/db.php';

$user_id = $_SESSION['user_id'];
$place_id = $_POST['place_id'];
$review_text = $_POST['review_text'];

$sql = "INSERT INTO reviews (user_id, place_id, review_text) 
        VALUES ('$user_id', '$place_id', '$review_text')";

if ($conn->query($sql)) {
    header("Location: ../place.php?id=$place_id");
} else {
    echo "Gagal menambahkan review: " . $conn->error;
}
