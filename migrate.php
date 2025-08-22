<?php

require __DIR__ . '/vendor/autoload.php';

use App\Core\Database;

// Liste as migrations na ordem certa
$migrations = [
    'CreateTenantsTable',
    'CreateRolesTable',
    'CreateUsersTable'
];

foreach ($migrations as $migrationClass) {
    require_once __DIR__ . "/database/migrations/{$migrationClass}.php";
    $migration = new $migrationClass();
    $migration->up();
    echo "Migration {$migrationClass} executada com sucesso.\n";
}
