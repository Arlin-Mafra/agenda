<?php
namespace App\Controllers;

use App\Core\Database;

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
                header("Location: /login.php");
                exit;
            }

        } catch(\Exception $e){
            error_log($e->getMessage());
            $_SESSION['error'] = "Erro interno, tente novamente";
            header("Location: /login.php");
            exit;
        }
    }

    public function register($data){
        // Futuro: implementar registro
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
