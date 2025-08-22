<?php

use App\Core\Database;

class CreateRolesTable
{
    public function up()
    {
        $db = Database::getConnection();

        $sql = "
            CREATE TABLE IF NOT EXISTS roles (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;
        ";

        $db->query($sql);
    }

    public function down()
    {
        $db = Database::getConnection();
        $db->query("DROP TABLE IF EXISTS roles");
    }
}
