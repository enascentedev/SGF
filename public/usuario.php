<?php
include_once __DIR__ . '/../src/config/db.php';
include_once __DIR__ . '/../src/controllers/UsuarioController.php';

// Instancia o controlador de usuário
$controller = new UsuarioController();

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	http_response_code(200);
	exit();
}
// Verifica o método de requisição e a ação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $data = json_decode(file_get_contents("php://input"), true);

    // Executa a ação com base no parâmetro de consulta "action"
    if ($_GET['action'] === 'register') {
        // Rota para registro de usuário
        $controller->register($data);
    } elseif ($_GET['action'] === 'login') {
        // Rota para login de usuário
        $controller->login($data);
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
