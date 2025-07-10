<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? 0;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM checklists WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: laporan.php");
exit;
?>
