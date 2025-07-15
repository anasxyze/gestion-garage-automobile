<?php
include 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: clients.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
$stmt->execute([$id]);

header("Location: clients.php");
exit;
?>