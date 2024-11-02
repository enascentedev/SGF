<?php
class Conta {
    private $conn;
    private $table_name;

    public $id;
    public $descricao;
    public $valor;
    public $data;
    public $status;
    public $categoria;

    public function __construct($db, $type = 'pagar') {
        $this->conn = $db;
        $this->table_name = $type === 'pagar' ? "contas_pagar" : "contas_receber";
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (descricao, valor, data, status, categoria)
                  VALUES (:descricao, :valor, :data, :status, :categoria)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':data', $this->data);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':categoria', $this->categoria);

        return $stmt->execute();
    }
}
