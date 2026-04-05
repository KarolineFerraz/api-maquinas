<?php
$host = "junction.proxy.rlwy.net";
$port = "13094";
$db = "railway";
$user = "root";
$pass = "HFYhqwrhIOYMmpViozyPlTdNUqODLnaf";

$pdo = null;

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
