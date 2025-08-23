<?php
session_start();

require __DIR__ . '/../app/Core/Database.php';
require __DIR__ . '/../app/Controllers/AuthController.php';

use App\Controllers\AuthController;

$action = $_GET['action'] ?? null;

$controller = new AuthController();

switch ($action) {
    case 'login':
        $controller->login($_POST);
        break;

    case 'register':
        $controller->register($_POST);
        break;

    case 'forgotPassword':
        $controller->forgotPassword($_POST);
        break;

    case 'logout':
        $controller->logout();
        break;

    default:
        include __DIR__ . '/login.php';
        break;
}
