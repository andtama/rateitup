<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include '../config/db.php';

$user_id = $_SESSION['user_id'];
$review_id = $_POST['review_id'];
$comment_text = $_POST['comment_text'];

$sql = "INSERT INTO comments (review_id, user_id, comment_text, status)
        VALUES ('$review_id', '$user_id', '$comment_text', 'pending')";

if ($conn->query($sql)) {
    header("Location: ../place.php?id=". $_POST['place_id']);
} else {
    echo "Gagal menambahkan komentar: " . $conn->error;
}
?>
