<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200611004021 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() != 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE construction ADD organization_id_backup int(11) DEFAULT NULL');
        $this->addSql(
            "update  construction c set
                         c.organization_id_backup = c.organization_id,
                         c.organization_id = null
            where c.id = c.id and c.organization_id in (
                select  o.id from organization o where o.publishable = 0
            )");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() != 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('alter table construction drop organization_id_backup');
        $this->addSql("update  construction c set
                c.organization_id = c.organization_id_backup,
                c.organization_id_backup = null
            where c.id = c.id and c.organization_id_backup in (
                select  o.id
                from organization o where o.publishable = 0
            )");
    }
}
