<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20230816092513 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction ADD unique_id VARCHAR(255) DEFAULT NULL, ADD data_unique_id VARCHAR(255) DEFAULT NULL, ADD pending_data_unique_id VARCHAR(255) DEFAULT NULL, ADD custom_data_unique_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DC91E26EE3C68343 ON construction (unique_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DC91E26E6C69C375 ON construction (data_unique_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DC91E26E976F1EC7 ON construction (pending_data_unique_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DC91E26E468CF6AF ON construction (custom_data_unique_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_DC91E26EE3C68343 ON construction');
        $this->addSql('DROP INDEX UNIQ_DC91E26E6C69C375 ON construction');
        $this->addSql('DROP INDEX UNIQ_DC91E26E976F1EC7 ON construction');
        $this->addSql('DROP INDEX UNIQ_DC91E26E468CF6AF ON construction');
        $this->addSql('ALTER TABLE construction DROP data_unique_id, DROP pending_data_unique_id, DROP custom_data_unique_id');
    }
}
