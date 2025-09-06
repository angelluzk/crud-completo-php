<?php
namespace App\Models;

class Usuario
{
    public ?int $id;
    public string $nome;
    public string $email;
    public ?string $criado_em;
    public ?string $atualizado_em;

    public function __construct(?int $id = null, string $nome = '', string $email = '', ?string $criado_em = null, ?string $atualizado_em = null)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->criado_em = $criado_em;
        $this->atualizado_em = $atualizado_em;
    }
}
