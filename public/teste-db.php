<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use APP\Core\Database;

$db = App\Core\Database::getConnection();

echo "Conexão bem-sucedida com o banco de dados!";
