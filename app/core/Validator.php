<?php
namespace App\Core;

/**
 * Validator simples com encadeamento.
 */
class Validator
{
    private array $errors = [];
    private array $data = [];

    public function __construct(array $data = [])
    {
        $this->setData($data);
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
                $this->errors[$field] = ucfirst($field) . ' é obrigatório.';
            }
        }
        return $this;
    }

    public function email(string $field): self
    {
        $val = $this->data[$field] ?? '';
        if ($val !== '' && !filter_var($val, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'E-mail inválido.';
        }
        return $this;
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