<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171106120500 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fos_user_user ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_user_user ADD CONSTRAINT FK_C560D7617E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_C560D7617E3C61F9 ON fos_user_user (owner_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fos_user_user DROP FOREIGN KEY FK_C560D7617E3C61F9');
        $this->addSql('DROP INDEX IDX_C560D7617E3C61F9 ON fos_user_user');
        $this->addSql('ALTER TABLE fos_user_user DROP owner_id');
    }
}
