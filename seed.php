<?php

require __DIR__ . '/vendor/autoload.php';

use App\database\seeds\DatabaseSeeder;

$seeder = new DatabaseSeeder();
$seeder->run();

echo "Seed executado com sucesso.\n";
