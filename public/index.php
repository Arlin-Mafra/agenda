<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    session_start();

    require __DIR__ . '/../app/Core/Database.php';
    require __DIR__ . '/../app/Controllers/AuthController.php';

    use App\Controllers\AuthController;

    $action = $_GET['action'] ?? null;

    try{

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


    } catch (\Throwable $e) {
        // Log para o error_log do PHP
        error_log('Fatal error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        // Exibir no navegador (apenas dev)
        echo '<h1>Erro fatal</h1><pre>' . htmlspecialchars($e->getMessage()) . "\n\n" . htmlspecialchars($e->getTraceAsString()) . '</pre>';
        exit;
    }
