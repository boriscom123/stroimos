<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201020214935 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("
            create table org_title_backup as
            select org.id, org.title, org.fullTitle from organization org
            where length(org.title) > length(org.fullTitle);
        ");
        $this->addSql("
            update organization org
            set org.fullTitle = (@temp := org.fullTitle),
                org.fullTitle = org.title,
                org.title     = @temp
            where length(org.title) > length(org.fullTitle)
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("
            update organization org, org_title_backup bk
            set org.fullTitle = bk.fullTitle,
                org.title     = bk.title
            where org.id = bk.id
        ");

        $this->addSql("drop table org_title_backup");
    }
}
