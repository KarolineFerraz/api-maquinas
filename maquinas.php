<?php
include 'conexao.php';

$sql = "SELECT * FROM maquinas";
$stmt = $conn->query($sql);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>