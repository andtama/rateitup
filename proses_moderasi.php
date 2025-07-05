<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$action = $_GET['action'];

$status = $action === 'approve' ? 'approved' : 'rejected';
$stmt = $conn->prepare("UPDATE comments SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);
$stmt->execute();

header("Location: moderasi_komentar.php");
?>

