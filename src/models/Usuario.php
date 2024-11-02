<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
        $this->checkAndCreateTable();
    }

    // Método para verificar e criar a tabela 'usuarios' se ela não existir
    private function checkAndCreateTable() {
        $query = "CREATE TABLE IF NOT EXISTS " . $this->table_name . " (
            id SERIAL PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL
        )";
        $this->conn->exec($query);
    }

    // Método para registrar um novo usuário
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (username, password) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($query);

        // Hash da senha e vinculação de parâmetros
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', password_hash($this->password, PASSWORD_BCRYPT));

        // Executa a inserção e retorna o resultado
        return $stmt->execute();
    }

    // Método de login para autenticar o usuário
    public function login() {
			error_log("Iniciando login para o usuário: " . $this->username);
	
			$query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':username', $this->username);
			$stmt->execute();
	
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
	
			// Verifica se o usuário existe e se a senha está correta
			if ($user && password_verify($this->password, $user['password'])) {
					error_log("Login bem-sucedido para o usuário: " . $this->username);
					// Retorna um token de autenticação simulado
					return bin2hex(random_bytes(16)); // Token simulado
			}
	
			error_log("Falha no login para o usuário: " . $this->username);
			return false;
	}
	
}
