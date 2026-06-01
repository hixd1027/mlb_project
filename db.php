<?php
$host = 'localhost';
$dbname = 'mlb_project';
$username = 'root'; 
$password = '';     

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
} catch(PDOException $e) {
    echo "資料庫連線失敗: " . $e->getMessage();
    exit;
}
?>