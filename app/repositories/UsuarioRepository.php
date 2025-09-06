<?php
namespace App\Repositories;

use PDO;

/**
 * Repositório responsável pela persistência dos usuários.
 * Usa prepared statements para evitar SQL injection.
 */
class UsuarioRepository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function all(): array
    {
        $stmt = $this->conn->query('SELECT * FROM usuarios ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->conn->prepare('SELECT * FROM usuarios WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->conn->prepare('INSERT INTO usuarios (nome, email, criado_em) VALUES (:nome, :email, NOW())');
        return $stmt->execute([
            'nome' => $data['nome'],
            'email' => $data['email']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->conn->prepare('UPDATE usuarios SET nome = :nome, email = :email, atualizado_em = NOW() WHERE id = :id');
        return $stmt->execute([
            'id' => $id,
            'nome' => $data['nome'],
            'email' => $data['email']
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare('DELETE FROM usuarios WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
?>