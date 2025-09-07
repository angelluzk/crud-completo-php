<?php

if (!function_exists('redirect')) {
    /**
     * Redireciona para um caminho dentro do projeto, usando a APP_URL.
     */
    function redirect(string $path): void
    {
        header("Location: " . url($path));
        exit;
    }
}

if (!function_exists('url')) {
    /**
     * Gera uma URL completa para um caminho dentro do projeto.
     */
    function url(string $path): string
    {
        return rtrim($_ENV['APP_URL'], '/') . '/' . ltrim($path, '/');
    }
}
?>