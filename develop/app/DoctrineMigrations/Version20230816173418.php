<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20230816173418 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction ADD data_main_functional_code VARCHAR(255) DEFAULT NULL, ADD pending_data_main_functional_code VARCHAR(255) DEFAULT NULL, ADD custom_data_main_functional_code VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE stadium ADD data_main_functional_code VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction DROP data_main_functional_code, DROP pending_data_main_functional_code, DROP custom_data_main_functional_code');
        $this->addSql('ALTER TABLE stadium DROP data_main_functional_code');
    }
}
