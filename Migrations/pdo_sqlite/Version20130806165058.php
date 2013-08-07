<?php

namespace Claroline\AssignmentBundle\Migrations\pdo_sqlite;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2013/08/06 04:50:58
 */
class Version20130806165058 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TEMPORARY TABLE __temp__claro_assignment AS 
            SELECT id, 
            instructions, 
            start_date, 
            end_date, 
            allow_late_upload, 
            public_works 
            FROM claro_assignment
        ");
        $this->addSql("
            DROP TABLE claro_assignment
        ");
        $this->addSql("
            CREATE TABLE claro_assignment (
                id INTEGER NOT NULL, 
                instructions VARCHAR(255) NOT NULL, 
                start_date DATETIME DEFAULT NULL, 
                end_date DATETIME DEFAULT NULL, 
                allow_late_upload BOOLEAN NOT NULL, 
                is_public BOOLEAN NOT NULL, 
                PRIMARY KEY(id), 
                CONSTRAINT FK_524CCFE0BF396750 FOREIGN KEY (id) 
                REFERENCES claro_resource (id) 
                ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        ");
        $this->addSql("
            INSERT INTO claro_assignment (
                id, instructions, start_date, end_date, 
                allow_late_upload, is_public
            ) 
            SELECT id, 
            instructions, 
            start_date, 
            end_date, 
            allow_late_upload, 
            public_works 
            FROM __temp__claro_assignment
        ");
        $this->addSql("
            DROP TABLE __temp__claro_assignment
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            CREATE TEMPORARY TABLE __temp__claro_assignment AS 
            SELECT id, 
            instructions, 
            start_date, 
            end_date, 
            allow_late_upload, 
            is_public 
            FROM claro_assignment
        ");
        $this->addSql("
            DROP TABLE claro_assignment
        ");
        $this->addSql("
            CREATE TABLE claro_assignment (
                id INTEGER NOT NULL, 
                instructions VARCHAR(255) NOT NULL, 
                start_date DATETIME DEFAULT NULL, 
                end_date DATETIME DEFAULT NULL, 
                allow_late_upload BOOLEAN NOT NULL, 
                public_works BOOLEAN NOT NULL, 
                PRIMARY KEY(id), 
                CONSTRAINT FK_524CCFE0BF396750 FOREIGN KEY (id) 
                REFERENCES claro_resource (id) 
                ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        ");
        $this->addSql("
            INSERT INTO claro_assignment (
                id, instructions, start_date, end_date, 
                allow_late_upload, public_works
            ) 
            SELECT id, 
            instructions, 
            start_date, 
            end_date, 
            allow_late_upload, 
            is_public 
            FROM __temp__claro_assignment
        ");
        $this->addSql("
            DROP TABLE __temp__claro_assignment
        ");
    }
}