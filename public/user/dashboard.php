<?php
require __DIR__ . '/../app/Helpers/auth_check.php';

// Bloquear admin aqui
if ($_SESSION['user']['role_id'] == 1) {
    header("Location: ../admin/dashboard.php");
    exit;
}
?>
<h1>Bem-vindo, <?= htmlspecialchars($_SESSION['user']['nome']); ?> (Usuário)</h1>
<a href="../index.php?action=logout">Sair</a>
