<?php

namespace App\database\seeds;

use App\Core\Database;

class UserTenantSeeder
{
    public function run()
    {
        $db = Database::getConnection();

        // Inserir novo tenant para usuários comuns
        $db->query("INSERT INTO tenants (nome_empresa, plano, status) VALUES ('Empresa Usuários', 'basic', 'ativo')");

        // Pegar o ID do tenant recém-criado (assumindo que será ID 2)
        $tenantId = 2;

        // Usuários comuns para o novo tenant
        $usuarios = [
            [
                'nome' => 'João Silva',
                'email' => 'joao@usuarios.com',
                'senha' => 'user123'
            ],
            [
                'nome' => 'Maria Santos',
                'email' => 'maria@usuarios.com', 
                'senha' => 'user123'
            ],
            [
                'nome' => 'Pedro Costa',
                'email' => 'pedro@usuarios.com',
                'senha' => 'user123'
            ],
            [
                'nome' => 'Ana Oliveira',
                'email' => 'ana@usuarios.com',
                'senha' => 'user123'
            ]
        ];

        $sql = "INSERT INTO users (nome, email, senha_hash, role_id, tenant_id, status, created_at)
                VALUES (:nome, :email, :senha_hash, 2, :tenant_id, 'ativo', NOW())";
        
        $stmt = $db->prepare($sql);

        foreach ($usuarios as $usuario) {
            $senhaHash = password_hash($usuario['senha'], PASSWORD_DEFAULT);
            
            $stmt->execute([
                ':nome' => $usuario['nome'],
                ':email' => $usuario['email'],
                ':senha_hash' => $senhaHash,
                ':tenant_id' => $tenantId
            ]);
        }

        echo "Tenant 2 e usuários comuns criados com sucesso!\n";
    }
}