<?php
// em public/index.php (ou no topo dos seus arquivos php que são ponto de entrada)
require_once __DIR__ . '/../config/app.php';
session_start();
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

if (isset($_SESSION['user'])) {
    // Redireciona conforme role
    if ($_SESSION['user']['role_id'] == 1) header("Location: /admin/dashboard.php");
    else header("Location: /user/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php include __DIR__ . '/partials/head_tags.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Entrar - AgendaPro</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<main class="auth-card">
    <div class="brand">
        <img src="images/logo.svg" alt="Logo AgendaPro">
        <h1>AgendaPro</h1>
    </div>
    <h2 class="page-title">Entrar</h2>

    <?php if ($error): ?>
        <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?action=login" method="POST">
        <div class="field">
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" placeholder="seuemail@empresa.com" required>
        </div>
        <div class="field">
            <label for="senha">Senha</label>
            <input id="senha" type="password" name="senha" placeholder="••••••••" required>
        </div>
        <br>

        <button class="button" type="submit">Entrar</button>
    </form>
    <div class="link-row">
        <a href="register.php">Criar conta</a>
        <a href="forgot-password.php">Esqueci minha senha</a>
    </div>
</main>
</body>
</html>
