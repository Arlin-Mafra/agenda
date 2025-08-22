<?php

use App\Core\Database;

class CreateTenantsTable
{
    private $db;

    public function up()
    {
        $this->db = Database::getConnection();
        $sql = "
            CREATE TABLE IF NOT EXISTS tenants (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome_empresa VARCHAR(255) NOT NULL,
                plano VARCHAR(100) NOT NULL,
                status ENUM('ativo','inativo') DEFAULT 'ativo',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;
        ";
        $this->db->query($sql);
    }

    public function down()
    {
        $this->db = Database::getConnection();
        $this->db->query("DROP TABLE IF EXISTS tenants");
    }
}
