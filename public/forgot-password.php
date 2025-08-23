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
  <title>Recuperar senha - AgendaPro</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <main class="auth-card" role="main">
    <div class="brand">
      <img src="images/logo.svg" alt="Logo AgendaPro">
      <h1>AgendaPro</h1>
    </div>
    <h2 class="page-title">Recuperar senha</h2>

    <?php if ($error): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="alert success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form class="auth-form" action="../app/Controllers/AuthController.php?action=forgotPassword" method="POST" novalidate>
      <div class="field">
        <label for="email">Digite seu e-mail</label>
        <input id="email" type="email" name="email" placeholder="seuemail@empresa.com" required>
      </div>
      <button class="button" type="submit">Enviar link de recuperação</button>
    </form>

    <div class="link-row">
      <a href="login.php">Voltar ao login</a>
    </div>
  </main>
</body>
</html>
