<?php
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function register($data) {
        $this->usuario->username = $data['username'];
        $this->usuario->password = $data['password'];

        if ($this->usuario->create()) {
            echo json_encode(["message" => "Usuário registrado com sucesso"]);
        } else {
            echo json_encode(["message" => "Erro ao registrar usuário"]);
        }
    }

    public function login($data) {
        error_log("Iniciando login para o usuário: " . $data['username']);
        
        $this->usuario->username = $data['username'];
        $this->usuario->password = $data['password'];

        $token = $this->usuario->login();
        
        if ($token) {
            error_log("Login bem-sucedido. Token gerado: " . $token);
            echo json_encode(["message" => "Login bem-sucedido", "token" => $token]);
        } else {
            error_log("Falha no login. Credenciais inválidas para o usuário: " . $data['username']);
            http_response_code(401);
            echo json_encode(["message" => "Credenciais inválidas"]);
        }
    }
}
