<?php
include_once __DIR__ . '/../src/config/db.php';
include_once __DIR__ . '/../src/controllers/ContaController.php';

$controller = new ContaController();

// Lida com requisições OPTIONS para CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Verifica o método de requisição e a ação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($_GET['action'] === 'pagar') {
        // Rota para registrar conta a pagar
        $controller->registrarContaPagar($data);
    } elseif ($_GET['action'] === 'receber') {
        // Rota para registrar conta a receber
        $controller->registrarContaReceber($data);
    } else {
        // Retorna uma mensagem de erro para ações desconhecidas
        http_response_code(400);
        echo json_encode(["message" => "Ação inválida"]);
    }
} else {
    // Retorna uma mensagem de erro para métodos de requisição não permitidos
    http_response_code(405);
    echo json_encode(["message" => "Método não permitido"]);
}
