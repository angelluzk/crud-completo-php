<?php
namespace App\Core;

use PDO;

class Validator
{
    private array $errors = [];
    private array $data = [];
    private PDO $db;

    private array $messages = [
        'required' => '%s é obrigatório.',
        'email'    => 'O campo %s deve ser um e-mail válido.',
        'min'      => 'O campo %s deve ter no mínimo %d caracteres.',
        'max'      => 'O campo %s deve ter no máximo %d caracteres.',
        'equals'   => 'O campo %s deve ser igual ao campo %s.',
        'unique'   => 'O valor do campo %s já está em uso.',
    ];

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        $this->errors = [];
        return $this;
    }

    public function required(string ...$fields): self
    {
        foreach ($fields as $field) {
            if (empty(trim($this->data[$field] ?? ''))) {
                $this->addError($field, sprintf($this->messages['required'], ucfirst($field)));
            }
        }
        return $this;
    }

    public function email(string $field): self
    {
        $value = $this->data[$field] ?? '';
        if ($value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, sprintf($this->messages['email'], ucfirst($field)));
        }
        return $this;
    }

    public function min(string $field, int $length): self
    {
        $value = $this->data[$field] ?? '';
        if ($value !== '' && mb_strlen(trim($value)) < $length) {
            $this->addError($field, sprintf($this->messages['min'], ucfirst($field), $length));
        }
        return $this;
    }

    public function max(string $field, int $length): self
    {
        $value = $this->data[$field] ?? '';
        if ($value !== '' && mb_strlen(trim($value)) > $length) {
            $this->addError($field, sprintf($this->messages['max'], ucfirst($field), $length));
        }
        return $this;
    }

    public function unique(string $field, string $table, ?int $exceptId = null): self
    {
        $value = $this->data[$field] ?? '';
        if ($value === '') {
            return $this;
        }

        $sql = "SELECT COUNT(*) FROM {$table} WHERE {$field} = ?";
        $params = [$value];

        if ($exceptId !== null) {
            $sql .= " AND id != ?";
            $params[] = $exceptId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        if ($stmt->fetchColumn() > 0) {
            $this->addError($field, sprintf($this->messages['unique'], ucfirst($field)));
        }
        return $this;
    }

    private function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = $message;
        }
    }

    public function passed(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
?>