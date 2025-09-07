<?php
namespace App\Core;

final class Csrf
{
    private const SESSION_KEY = 'csrf_token';

    private function __construct() {}

    public static function getToken(): string
    {
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::SESSION_KEY];
    }

    public static function validate(string $token): bool
    {
        $sessionToken = $_SESSION[self::SESSION_KEY] ?? null;

        if ($sessionToken === null || $token === '') {
            return false;
        }

        $isValid = hash_equals($sessionToken, $token);

        if ($isValid) {
            self::regenerateToken();
        }

        return $isValid;
    }

    public static function inputField(): string
    {
        $token = self::getToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }
    
    public static function regenerateToken(): void
    {
        if (isset($_SESSION[self::SESSION_KEY])) {
            unset($_SESSION[self::SESSION_KEY]);
        }
    }
}
?>