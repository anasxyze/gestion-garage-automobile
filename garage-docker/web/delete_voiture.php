<?php
include 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: voitures.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM voitures WHERE id = ?");
$stmt->execute([$id]);

header("Location: voitures.php");
exit;
?>