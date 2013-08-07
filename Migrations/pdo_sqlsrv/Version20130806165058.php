<?php

namespace Claroline\AssignmentBundle\Migrations\pdo_sqlsrv;

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
            sp_RENAME 'claro_assignment.public_works', 
            'is_public', 
            'COLUMN'
        ");
        $this->addSql("
            ALTER TABLE claro_assignment ALTER COLUMN is_public BIT NOT NULL
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            sp_RENAME 'claro_assignment.is_public', 
            'public_works', 
            'COLUMN'
        ");
        $this->addSql("
            ALTER TABLE claro_assignment ALTER COLUMN public_works BIT NOT NULL
        ");
    }
}