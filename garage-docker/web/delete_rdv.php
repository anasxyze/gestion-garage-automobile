<?php
include 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: rdv.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM rdv WHERE id = ?");
$stmt->execute([$id]);

header("Location: rdv.php");
exit;
?>