<?php

class Conta {
    private $conn;
    private $table_pagar = "contas_pagar";
    private $table_receber = "contas_receber";

    public $descricao;
    public $valor;
    public $data_vencimento;
    public $data_recebimento;
    public $categoria;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
        $this->checkAndCreateTables();
    }

    // Verifica e cria as tabelas se não existirem
    private function checkAndCreateTables() {
        $queryPagar = "CREATE TABLE IF NOT EXISTS " . $this->table_pagar . " (
            id SERIAL PRIMARY KEY,
            descricao VARCHAR(255),
            valor DECIMAL(10, 2),
            data_vencimento DATE,
            categoria VARCHAR(50),
            status VARCHAR(20)
        )";

        $queryReceber = "CREATE TABLE IF NOT EXISTS " . $this->table_receber . " (
            id SERIAL PRIMARY KEY,
            descricao VARCHAR(255),
            valor DECIMAL(10, 2),
            data_recebimento DATE,
            categoria VARCHAR(50),
            status VARCHAR(20)
        )";

        $this->conn->exec($queryPagar);
        $this->conn->exec($queryReceber);
    }

    // Método para criar uma conta a pagar
    public function createPagar() {
        $query = "INSERT INTO " . $this->table_pagar . " (descricao, valor, data_vencimento, categoria, status)
                  VALUES (:descricao, :valor, :data_vencimento, :categoria, :status)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':data_vencimento', $this->data_vencimento);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':status', $this->status);

        return $stmt->execute();
    }

    // Método para criar uma conta a receber
    public function createReceber() {
        $query = "INSERT INTO " . $this->table_receber . " (descricao, valor, data_recebimento, categoria, status)
                  VALUES (:descricao, :valor, :data_recebimento, :categoria, :status)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':data_recebimento', $this->data_recebimento);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':status', $this->status);

        return $stmt->execute();
    }
}
