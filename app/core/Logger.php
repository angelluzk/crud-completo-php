<?php
namespace App\Core;

/**
 * 
 * 
 */
class Logger
{
    private const LOG_FILE = __DIR__ . '/../../app.log';

    public static function error(string $message): void
    {
        $line = sprintf("[%s] ERROR: %s\n", date('Y-m-d H:i:s'), $message);
        @file_put_contents(self::LOG_FILE, $line, FILE_APPEND | LOCK_EX);
    }

    public static function info(string $message): void
    {
        $line = sprintf("[%s] INFO: %s\n", date('Y-m-d H:i:s'), $message);
        @file_put_contents(self::LOG_FILE, $line, FILE_APPEND | LOCK_EX);
    }
}
