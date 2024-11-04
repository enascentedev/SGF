<?php
include_once __DIR__ . '/../src/config/db.php';
include_once __DIR__ . '/../src/controllers/RelatorioController.php';

$controller = new RelatorioController();

// Lida com requisições OPTIONS para CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Verifica o método de requisição e a ação
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    // Rota para relatório de despesas por categoria
    if ($_GET['action'] === 'despesasPorCategoria') {
        $mes = $_GET['mes'] ?? null;
        $ano = $_GET['ano'] ?? null;
        
        if ($mes && $ano) {
            $controller->despesasPorCategoria($mes, $ano);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Parâmetros 'mes' e 'ano' são obrigatórios"]);
        }

    // Rota para relatório de saldo de contas
    } elseif ($_GET['action'] === 'saldoContas') {
        $mes = $_GET['mes'] ?? null;
        $ano = $_GET['ano'] ?? null;
        
        if ($mes && $ano) {
            $controller->saldoContas($mes, $ano);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Parâmetros 'mes' e 'ano' são obrigatórios"]);
        }

    // Rota para relatório de transações de cartão de crédito
    } elseif ($_GET['action'] === 'transacoesCartao') {
        $cartao_id = $_GET['cartao_id'] ?? null;
        $mes = $_GET['mes'] ?? null;
        $ano = $_GET['ano'] ?? null;

        if ($cartao_id && $mes && $ano) {
            $controller->transacoesCartao($cartao_id, $mes, $ano);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Parâmetros 'cartao_id', 'mes' e 'ano' são obrigatórios"]);
        }

    } else {
        http_response_code(400);
        echo json_encode(["message" => "Ação inválida"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Método não permitido"]);
}
