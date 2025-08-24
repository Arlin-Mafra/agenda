<?php
require __DIR__ . '/../../app/Helpers/auth_check.php';

// Permitir apenas admin
if ($_SESSION['user']['role_id'] != 1) {
    header("Location: ../user/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php include __DIR__ . '/../partials/head_tags.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard - AgendaPro</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<h1>Bem-vindo, <?= htmlspecialchars($_SESSION['user']['nome']); ?> (Admin)</h1>
<a href="../index.php?action=logout">Sair</a>
</html>