<?php
namespace App\Repositories;

use App\Models\Usuario;
use PDO;
use Exception;

class UsuarioRepository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * @return Usuario[]
     */
    public function all(): array
    {
        $stmt = $this->conn->query('SELECT * FROM usuarios ORDER BY id DESC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'hydrateUsuario'], $rows);
    }

    public function find(int $id): ?Usuario
    {
        $stmt = $this->conn->prepare('SELECT * FROM usuarios WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->hydrateUsuario($row) : null;
    }

    public function create(array $data): ?Usuario
    {
        $stmt = $this->conn->prepare('INSERT INTO usuarios (nome, email, criado_em) VALUES (:nome, :email, NOW())');
        $success = $stmt->execute([
            'nome' => $data['nome'],
            'email' => $data['email']
        ]);

        if ($success) {
            $id = (int) $this->conn->lastInsertId();
            return $this->find($id);
        }

        return null;
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

    private function hydrateUsuario(array $data): Usuario
    {
        try {
            return new Usuario(
                (int) $data['id'],
                $data['nome'],
                $data['email'],
                $data['criado_em'],
                $data['atualizado_em']
            );
        } catch (Exception $e) {
            throw new \RuntimeException("Erro ao hidratar usuário: " . $e->getMessage(), 0, $e);
        }
    }
}
?>