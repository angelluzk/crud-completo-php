<?php
namespace App\Core;

use Throwable;

final class Logger
{
    private const LOG_FILE = __DIR__ . '/../../storage/logs/app.log';

    private function __construct() {}

    public static function info(string $message): void
    {
        self::log('INFO', $message);
    }

    public static function error(string $message): void
    {
        self::log('ERROR', $message);
    }

    private static function log(string $level, string $message): void
    {
        try {
            $logFile = $_ENV['LOG_PATH'] ?? self::LOG_FILE;
            
            $line = sprintf(
                "[%s] %s: %s\n",
                date('Y-m-d H:i:s'),
                strtoupper($level),
                $message
            );

            file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);

        } catch (Throwable $e) {
            error_log(
                "CRITICAL: Falha ao escrever no arquivo de log. Erro original: " . $e->getMessage()
            );
        }
    }
}
?>