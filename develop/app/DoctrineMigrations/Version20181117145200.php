<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181117145200 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE road ADD extra_information_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE road ADD CONSTRAINT FK_95C0C4B1BA0F69B9 FOREIGN KEY (extra_information_id) REFERENCES extra_information (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_95C0C4B1BA0F69B9 ON road (extra_information_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE road DROP FOREIGN KEY FK_95C0C4B1BA0F69B9');
        $this->addSql('DROP INDEX UNIQ_95C0C4B1BA0F69B9 ON road');
        $this->addSql('ALTER TABLE road DROP extra_information_id');
    }
}
