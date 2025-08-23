<?php
require __DIR__ . '/../../app/Helpers/auth_check.php';

// Permitir apenas admin
if ($_SESSION['user']['role_id'] != 1) {
    header("Location: ../user/dashboard.php");
    exit;
}
?>
<h1>Bem-vindo, <?= htmlspecialchars($_SESSION['user']['nome']); ?> (Admin)</h1>
<a href="../index.php?action=logout">Sair</a>
