<?php
include_once '../config/db.php';
include_once '../models/Conta.php';
include_once '../middleware/auth.php';

class ContaController {
    private $db;
    private $conta;

    public function __construct($type = 'pagar') {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->conta = new Conta($this->db, $type);
    }

    public function create($data) {
        if (!authenticate()) return;

        $this->conta->descricao = $data['descricao'];
        $this->conta->valor = $data['valor'];
        $this->conta->data = $data['data'];
        $this->conta->status = $data['status'];
        $this->conta->categoria = $data['categoria'];

        if($this->conta->create()) {
            echo json_encode(["message" => "Conta criada com sucesso."]);
        } else {
            echo json_encode(["message" => "Erro ao criar conta."]);
        }
    }
}
