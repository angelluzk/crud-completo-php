<?php
namespace App\Core;

/**
 * CSRF helper simples.
 */
class Csrf
{
    public static function getToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            // gera token seguro
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validate(string $token): bool
    {
        return hash_equals((string)($_SESSION['csrf_token'] ?? ''), (string)$token);
    }

    public static function inputField(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(self::getToken()) . '">';
    }
}
?>