<?php
include '../config/db.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
if ($conn->query($sql)) {
    header("Location: ../public/login.php");
} else {
    echo "Gagal mendaftar: " . $conn->error;
}
?>