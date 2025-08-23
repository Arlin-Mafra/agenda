<?php

namespace App\database\seeds;

use App\Core\Database;

class DatabaseSeeder
{
    public function run()
    {
        $db = Database::getConnection();

        // Inserir tenants
        $db->query("INSERT INTO tenants (nome_empresa, plano, status) VALUES ('Empresa Padrão', 'premium', 'ativo')");

        // Inserir roles
        $db->query("INSERT INTO roles (nome) VALUES ('admin'), ('user')");

        // Inserir usuário admin
        $senhaHash = password_hash('admin123', PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (nome, email, senha_hash, role_id, tenant_id, status)
                VALUES ('Administrador', 'admin@empresa.com', :senha_hash, 1, 1, 'ativo')";
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':senha_hash', $senhaHash);
        $stmt->execute();
    }
}
