<?php
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../models/Conta.php';
include_once __DIR__ . '/../middleware/auth.php'; // Inclui o arquivo de autenticação

class ContaController {
    private $db;
    private $contaPagar;
    private $contaReceber;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->contaPagar = new Conta($this->db, 'pagar');
        $this->contaReceber = new Conta($this->db, 'receber');
    }

    // Método para registrar uma conta a pagar
    public function registrarContaPagar($data) {
        authenticate(); // Verifica a autorização antes de prosseguir

        $this->contaPagar->descricao = $data['descricao'];
        $this->contaPagar->valor = $data['valor'];
        $this->contaPagar->data_vencimento = $data['data_vencimento'];
        $this->contaPagar->categoria = $data['categoria'];
        $this->contaPagar->status = $data['status'];

        if ($this->contaPagar->createPagar()) {
            echo json_encode(["message" => "Conta a pagar registrada com sucesso"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Erro ao registrar conta a pagar"]);
        }
    }

    // Método para registrar uma conta a receber
    public function registrarContaReceber($data) {
        authenticate(); // Verifica a autorização antes de prosseguir

        $this->contaReceber->descricao = $data['descricao'];
        $this->contaReceber->valor = $data['valor'];
        $this->contaReceber->data_recebimento = $data['data_recebimento'];
        $this->contaReceber->categoria = $data['categoria'];
        $this->contaReceber->status = $data['status'];

        if ($this->contaReceber->createReceber()) {
            echo json_encode(["message" => "Conta a receber registrada com sucesso"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Erro ao registrar conta a receber"]);
        }
    }
}
