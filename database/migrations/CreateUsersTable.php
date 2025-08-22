<?php

use App\Core\Database;

class CreateUsersTable
{
    public function up()
    {
        $db = Database::getConnection();
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                senha_hash VARCHAR(255) NOT NULL,
                role_id INT NOT NULL,
                tenant_id INT NOT NULL,
                status ENUM('ativo','inativo') DEFAULT 'ativo',
                ultimo_login DATETIME NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (role_id) REFERENCES roles(id),
                FOREIGN KEY (tenant_id) REFERENCES tenants(id)
            ) ENGINE=InnoDB;
        ";
        $db->query($sql);
    }

    public function down()
    {
        $db = Database::getConnection();
        $db->query("DROP TABLE IF EXISTS users");
    }
}
