<?php
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../models/Relatorio.php';
include_once __DIR__ . '/../middleware/auth.php';


class RelatorioController {
    private $db;
    private $relatorio;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->relatorio = new Relatorio($this->db);
    }

    // Relatório de despesas por categoria para um mês e ano específicos
    public function despesasPorCategoria($mes, $ano) {
        if (!authenticate()) return;

        $result = $this->relatorio->despesasPorCategoria($mes, $ano);
        echo json_encode(["data" => $result]);
    }

    // Relatório de saldo entre contas a pagar e receber
    public function saldoContas($mes, $ano) {
        if (!authenticate()) return;

        $result = $this->relatorio->saldoContas($mes, $ano);
        echo json_encode(["data" => $result]);
    }

    // Relatório de transações de cartão de crédito
    public function transacoesCartao($cartao_id, $mes, $ano) {
        if (!authenticate()) return;

        $result = $this->relatorio->transacoesCartao($cartao_id, $mes, $ano);
        echo json_encode(["data" => $result]);
    }
}
