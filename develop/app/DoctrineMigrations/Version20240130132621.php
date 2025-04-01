<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20240130132621 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction DROP data_unique_id, DROP pending_data_unique_id, DROP custom_data_unique_id');
        $this->addSql('DROP INDEX UNIQ_E604044F6C69C375 ON stadium');
        $this->addSql('ALTER TABLE stadium DROP data_unique_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction ADD data_unique_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD pending_data_unique_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD custom_data_unique_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE stadium ADD data_unique_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E604044F6C69C375 ON stadium (data_unique_id)');
    }
}
