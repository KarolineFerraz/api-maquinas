<?php
include 'conexao.php';

$sql = "
SELECT 
    mo.id,
    mo.nome_modelo,
    AVG(t.valor_db) AS media_db,
    SUM(CASE WHEN t.status_ligado = 1 THEN 1 ELSE 0 END) AS vezes_ligada,
    CASE
        WHEN AVG(t.valor_db) >= m.limite_db_critico THEN 'CRITICO'
        WHEN AVG(t.valor_db) >= m.limite_db_manutencao THEN 'MANUTENCAO'
        ELSE 'NORMAL'
    END AS status_alerta
FROM modelos mo
JOIN maquinas m ON mo.id_maquina = m.id
JOIN tabela_bruta t ON mo.id = t.id_modelo
GROUP BY mo.id, mo.nome_modelo, m.limite_db_manutencao, m.limite_db_critico
";

$stmt = $pdo->query($sql);
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($dados);
?>