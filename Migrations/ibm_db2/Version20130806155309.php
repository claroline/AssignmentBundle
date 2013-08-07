<?php

namespace Claroline\AssignmentBundle\Migrations\ibm_db2;

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
                id INTEGER NOT NULL, 
                instructions VARCHAR(255) NOT NULL, 
                start_date TIMESTAMP(0) DEFAULT NULL, 
                end_date TIMESTAMP(0) DEFAULT NULL, 
                allow_late_upload SMALLINT NOT NULL, 
                public_works SMALLINT NOT NULL, 
                PRIMARY KEY(id)
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