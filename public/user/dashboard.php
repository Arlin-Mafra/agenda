<?php
require __DIR__ . '/../../app/Helpers/auth_check.php';

// Bloquear admin aqui
if ($_SESSION['user']['role_id'] == 1) {
    header("Location: ../admin/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php include PUBLIC_PATH . '/partials/head_tags.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard - AgendaPro</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<h1>Bem-vindo, <?= htmlspecialchars($_SESSION['user']['nome']); ?> (Usuário)</h1>
<a href="../index.php?action=logout">Sair</a>
</html>
