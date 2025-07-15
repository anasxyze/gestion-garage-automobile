<?php
include 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: services.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
$stmt->execute([$id]);

header("Location: services.php");
exit;
include 'includes/header.php';
?>