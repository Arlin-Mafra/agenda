<?php

require __DIR__ . '/vendor/autoload.php';

use App\database\seeds\DatabaseSeeder;
use App\database\seeds\UserTenantSeeder;

// $seeder = new DatabaseSeeder();
// $seeder->run();

$seederTenant = new UserTenantSeeder();
$seederTenant->run();

echo "Seeds executado com sucesso.\n";
