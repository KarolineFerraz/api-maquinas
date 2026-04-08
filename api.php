<?php
include 'conexao.php';

header('Content-Type: application/json; charset=utf-8');

$rota = $_GET['rota'] ?? '';
$metodo = $_SERVER['REQUEST_METHOD'];

//  GET - DASHBOARD
if ($rota == 'dashboard' && $metodo == 'GET') {

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
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

//  POST - INSERIR DADOS
if ($rota == 'inserir' && $metodo == 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    $sql = "INSERT INTO tabela_bruta (id_modelo, valor_db, status_ligado)
            VALUES (?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['id_modelo'],
        $data['valor_db'],
        $data['status_ligado']
    ]);

    echo json_encode(["status" => "ok"]);
    exit;
}

//  ROTA NÃO ENCONTRADA
echo json_encode(["erro" => "rota inválida"]);