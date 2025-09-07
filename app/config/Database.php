<?php
namespace App\Config;

use PDO;
use PDOException;
use App\Core\Logger;

final class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            try {
                $host = $_ENV['DB_HOST'] ?? 'localhost';
                $port = $_ENV['DB_PORT'] ?? '5432';
                $dbname = $_ENV['DB_DATABASE'] ?? 'crud';
                $user = $_ENV['DB_USERNAME'] ?? 'postgres';
                $pass = $_ENV['DB_PASSWORD'] ?? '';

                $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);

            } catch (PDOException $e) {
                Logger::error("Erro de conexão ao banco de dados: " . $e->getMessage());
                throw new \RuntimeException("Não foi possível conectar ao banco de dados.");
            }
        }

        return self::$instance;
    }
}
?>