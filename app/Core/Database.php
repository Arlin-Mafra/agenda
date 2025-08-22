<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $connection = null;

    public static function getConnection(): PDO {
        if (self::$connection === null) {
            // Carrega as configurações
            $config = require __DIR__ . '/../../config/database.php';

            if (!isset($config['host'], $config['dbname'], $config['user'], $config['password'])) {
                throw new \Exception("Configurações de banco de dados inválidas.");
            }

            $host = $config['host'];
            $port = $config['port'] ?? 3306;
            $db   = $config['dbname'];
            $user = $config['user'];
            $pass = $config['password'];
            $charset = $config['charset'] ?? 'utf8mb4';

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

            try {
                self::$connection = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                // Nunca exibir credenciais, apenas mensagem genérica
                error_log("Erro ao conectar no banco: " . $e->getMessage());
                die("Erro ao conectar ao banco de dados. Contate o administrador.");
            }
        }

        return self::$connection;
    }
}
