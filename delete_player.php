<?php
require_once 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $player_id = $_GET['id'];
    $sql = "DELETE FROM players WHERE player_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $player_id]);
}

header("Location: index.php");
exit;
?>