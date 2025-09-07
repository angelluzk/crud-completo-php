<?php
namespace App\Models;

use DateTimeImmutable;
use Exception;

class Usuario
{
    private ?int $id;
    private string $nome;
    private string $email;
    private ?DateTimeImmutable $criado_em;
    private ?DateTimeImmutable $atualizado_em;

    public function __construct(
        ?int $id = null,
        string $nome = '',
        string $email = '',
        ?string $criado_em = null,
        ?string $atualizado_em = null
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        
        $this->criado_em = $criado_em ? new DateTimeImmutable($criado_em) : null;
        $this->atualizado_em = $atualizado_em ? new DateTimeImmutable($atualizado_em) : null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCriadoEm(): ?DateTimeImmutable
    {
        return $this->criado_em;
    }

    public function getCriadoEmFormatado(string $formato = 'd/m/Y H:i:s'): ?string
    {
        return $this->criado_em?->format($formato);
    }
    
    public function getAtualizadoEm(): ?DateTimeImmutable
    {
        return $this->atualizado_em;
    }

    public function getAtualizadoEmFormatado(string $formato = 'd/m/Y H:i:s'): ?string
    {
        return $this->atualizado_em?->format($formato);
    }
}
?>