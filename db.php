<?php
session_start(); 

$host = 'localhost';
$dbuser = 'ciai_dbst';
$dbpassword = 'Nptu_123456';
$dbname = 'cej113028'; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "資料庫連線失敗: " . $e->getMessage();
    exit;
}
?>
