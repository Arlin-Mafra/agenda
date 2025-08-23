<?php
session_start();

require __DIR__ . '/vendor/autoload.php'; // Se estiver usando autoload do Composer
use App\Core\Database;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['password'] ?? '');

    if (empty($email) || empty($senha)) {
        $_SESSION['error'] = "Preencha todos os campos.";
        header("Location: login.php");
        exit;
    }

    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT u.id, u.nome, u.email, u.senha_hash, u.role_id, u.status, r.nome AS role_name
            FROM users u
            INNER JOIN roles r ON u.role_id = r.id
            WHERE u.email = :email
        ");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && $user['status'] === 'ativo' && password_verify($senha, $user['senha_hash'])) {
            // Cria a sessão
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nome' => $user['nome'],
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'role_name' => $user['role_name']
            ];

            // Redireciona com base na role
            if ((int)$user['role_id'] === 1) {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit;
        } else {
            $_SESSION['error'] = "Credenciais inválidas ou conta inativa.";
            header("Location: login.php");
            exit;
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        $_SESSION['error'] = "Erro interno. Tente novamente.";
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
