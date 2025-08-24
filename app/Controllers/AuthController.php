<?php
namespace App\Controllers;

use App\Core\Database;
use PDO;
use PDOException;

class AuthController {

    public function login($data) {
        $email = trim($data['email'] ?? '');
        $senha = trim($data['senha'] ?? '');

        if(!$email || !$senha){
            $_SESSION['error'] = "Preencha todos os campos";
            header("Location: /login.php");
            exit;
        }

        try{
            $db = Database::getConnection();
            $stmt = $db->prepare("
                SELECT u.id, u.nome, u.email, u.senha_hash, u.role_id, u.status, r.nome AS role_name
                FROM users u
                INNER JOIN roles r ON u.role_id = r.id
                WHERE u.email = :email
            ");
            $stmt->execute([':email'=>$email]);
            $user = $stmt->fetch();

            if($user && $user['status'] === 'ativo' && password_verify($senha, $user['senha_hash'])){
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'nome' => $user['nome'],
                    'email' => $user['email'],
                    'role_id' => $user['role_id'],
                    'role_name' => $user['role_name']
                ];

                if((int)$user['role_id'] === 1) header("Location: admin/dashboard.php");
                else header("Location: user/dashboard.php");

                exit;
            } else {
                $_SESSION['error'] = "Credenciais inválidas ou conta inativa";
                header("Location: login.php");
                exit;
            }

        } catch(\Exception $e){
            error_log($e->getMessage());
            $_SESSION['error'] = "Erro interno, tente novamente";
            header("Location: login.php");
            exit;
        }
    }

    public function register($data) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: register.php');
            exit;
        }

        // Checagem CSRF (se estiver usando)
        if (empty($data['csrf_token']) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $data['csrf_token'])) {
            header('Location: register.php?error=' . urlencode('Requisição inválida (CSRF).'));
            exit;
        }

        $nome = trim($data['nome'] ?? '');
        $email_raw = trim($data['email'] ?? '');
        $senha = $data['senha'] ?? '';
        $senha_confirm = $data['senha_confirm'] ?? '';

        if ($nome === '' || $email_raw === '' || $senha === '' || $senha_confirm === '') {
            header('Location: register.php?error=' . urlencode('Preencha todos os campos.'));
            exit;
        }

        if (!filter_var($email_raw, FILTER_VALIDATE_EMAIL)) {
            header('Location: register.php?error=' . urlencode('E-mail inválido.'));
            exit;
        }
        $email = strtolower($email_raw);

        if (strlen($senha) < 3) {
            header('Location: register.php?error=' . urlencode('A senha deve ter no mínimo 3 caracteres.'));
            exit;
        }

        if ($senha !== $senha_confirm) {
            header('Location: register.php?error=' . urlencode('As senhas não conferem.'));
            exit;
        }

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $pdo = Database::getConnection();

            // Verifica email duplicado
            $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
            $stmt->execute([':email' => $email]);
            if ($stmt->fetch()) {
                header('Location: register.php?error=' . urlencode('Este e-mail já está em uso.'));
                exit;
            }

            // Valores padrão (ajuste se necessário)
            $defaultRoleId = 2; // por exemplo 2 = usuário comum
            $tenantId = 2;   // ou um id real se multi-tenant
            $status = 'ativo';        // 1 = ativo (ajuste conforme seu schema)

            $insert = $pdo->prepare('
                INSERT INTO users (nome, email, senha_hash, role_id, tenant_id, status, created_at)
                VALUES (:nome, :email, :senha_hash, :role_id, :tenant_id, :status, NOW())
            ');

            $insert->bindValue(':nome', $nome);
            $insert->bindValue(':email', $email);
            $insert->bindValue(':senha_hash', $senha_hash);
            $insert->bindValue(':role_id', $defaultRoleId, PDO::PARAM_INT);

            if ($tenantId === null) {
                $insert->bindValue(':tenant_id', null, PDO::PARAM_NULL);
            } else {
                $insert->bindValue(':tenant_id', $tenantId, PDO::PARAM_INT);
            }

            $insert->bindValue(':status', $status);

            $ok = $insert->execute();

            if ($ok) {
                unset($_SESSION['csrf_token']);
                header('Location: login.php?success=' . urlencode('Conta criada com sucesso. Faça login.'));
                exit;
            } else {
                error_log('Register error: execute retornou false');
                header('Location: register.php?error=' . urlencode('Erro ao criar conta. Tente novamente mais tarde.'));
                exit;
            }

        } catch (\Exception $e) {
            // Log do erro para depuração (não mostrar ao usuário em produção)
            error_log('Register exception: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            header('Location: register.php?error=' . urlencode('Erro no servidor. '.$e->getTraceAsString()));
            exit;
        }
    }
    public function forgotPassword($data){
        // Futuro: implementar recuperação de senha
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php"); // redireciona para login
        exit;
    }
}
