<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel</title>
</head>
<body>
    <h1>Bem-vindo, <?= htmlspecialchars($user['nome']) ?>!</h1>
    <p>Tenant ID: <?= $user['tenant_id'] ?> | Role ID: <?= $user['role_id'] ?></p>
    <a href="../app/Controllers/AuthController.php?action=logout">Sair</a>
</body>
</html>
