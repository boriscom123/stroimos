<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170802103638 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE newsletter_infographics DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE newsletter_infographics ADD id INT AUTO_INCREMENT NOT NULL PRIMARY KEY, ADD priority_position SMALLINT DEFAULT 0 NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQUE_IDX ON newsletter_infographics (newsletter_id, infographics_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQUE_IDX ON newsletter_infographics');
        $this->addSql('ALTER TABLE newsletter_infographics DROP id, DROP priority_position');
        $this->addSql('ALTER TABLE newsletter_infographics ADD PRIMARY KEY (newsletter_id, infographics_id)');
    }
}
