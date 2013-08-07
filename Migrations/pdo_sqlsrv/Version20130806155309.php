<?php

namespace Claroline\AssignmentBundle\Migrations\pdo_sqlsrv;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2013/08/06 03:53:10
 */
class Version20130806155309 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE claro_assignment (
                id INT NOT NULL, 
                instructions NVARCHAR(255) NOT NULL, 
                start_date DATETIME2(6), 
                end_date DATETIME2(6), 
                allow_late_upload BIT NOT NULL, 
                public_works BIT NOT NULL, 
                PRIMARY KEY (id)
            )
        ");
        $this->addSql("
            ALTER TABLE claro_assignment 
            ADD CONSTRAINT FK_524CCFE0BF396750 FOREIGN KEY (id) 
            REFERENCES claro_resource (id) 
            ON DELETE CASCADE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP TABLE claro_assignment
        ");
    }
}