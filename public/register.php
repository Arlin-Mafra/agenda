<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Criar conta - AgendaPro</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <main class="auth-card" role="main">
    <div class="brand">
      <img src="images/logo.svg" alt="Logo AgendaPro">
      <h1>AgendaPro</h1>
    </div>
    <h2 class="page-title">Criar conta</h2>

    <?php if ($error): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="alert success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form class="auth-form" action="../app/Controllers/AuthController.php?action=register" method="POST" novalidate>
      <div class="field">
        <label for="nome">Nome completo</label>
        <input id="nome" type="text" name="nome" placeholder="Seu nome" required>
      </div>
      <div class="field">
        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" placeholder="seuemail@empresa.com" required>
      </div>
      <div class="field">
        <label for="senha">Senha</label>
        <input id="senha" type="password" name="senha" placeholder="Crie uma senha forte" required>
      </div>
      <div class="field">
        <label for="senha_confirm">Confirmar senha</label>
        <input id="senha_confirm" type="password" name="senha_confirm" placeholder="Repita a senha" required>
      </div>
      <button class="button" type="submit">Criar conta</button>
    </form>

    <div class="link-row">
      <a href="login.php">Já tem conta? Entrar</a>
    </div>
  </main>
</body>
</html>
