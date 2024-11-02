<?php
class Relatorio {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para gerar relatório de despesas por categoria
    public function despesasPorCategoria($mes, $ano) {
        $query = "SELECT categoria, SUM(valor) as total
                  FROM contas_pagar
                  WHERE EXTRACT(MONTH FROM data_vencimento) = :mes
                    AND EXTRACT(YEAR FROM data_vencimento) = :ano
                  GROUP BY categoria";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':mes', $mes);
        $stmt->bindParam(':ano', $ano);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para gerar o saldo entre contas a pagar e receber
    public function saldoContas($mes, $ano) {
        $query = "
            SELECT
                (SELECT COALESCE(SUM(valor), 0) FROM contas_receber 
                 WHERE EXTRACT(MONTH FROM data_recebimento) = :mes 
                 AND EXTRACT(YEAR FROM data_recebimento) = :ano) as total_receitas,
                (SELECT COALESCE(SUM(valor), 0) FROM contas_pagar 
                 WHERE EXTRACT(MONTH FROM data_vencimento) = :mes 
                 AND EXTRACT(YEAR FROM data_vencimento) = :ano) as total_despesas";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':mes', $mes);
        $stmt->bindParam(':ano', $ano);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para gerar relatório de transações de cartão de crédito
    public function transacoesCartao($cartao_id, $mes, $ano) {
        $query = "SELECT descricao, valor, data_compra, categoria, parcelas
                  FROM cartao_compras
                  WHERE cartao_id = :cartao_id
                    AND EXTRACT(MONTH FROM data_compra) = :mes
                    AND EXTRACT(YEAR FROM data_compra) = :ano";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cartao_id', $cartao_id);
        $stmt->bindParam(':mes', $mes);
        $stmt->bindParam(':ano', $ano);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
