<?php
require_once __DIR__ . '/../../config/Database.php';

class Usuario {
    private $conn;
    private $tabela = 'usuarios';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function listar() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->tabela} ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->tabela} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($dados) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->tabela} (nome, email) VALUES (:nome, :email)"
        );
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':email', $dados['email']);
        return $stmt->execute();
    }

    public function atualizar($id, $dados) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->tabela} 
             SET nome = :nome, email = :email, atualizado_em = CURRENT_TIMESTAMP
             WHERE id = :id"
        );
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deletar($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->tabela} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>