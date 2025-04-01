<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20230818132557 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FROM construction WHERE end_year < 2022');
        $this->addSql('ALTER TABLE construction ADD data_object_polygon LONGTEXT DEFAULT NULL, ADD pending_data_object_polygon LONGTEXT DEFAULT NULL, ADD custom_data_object_polygon LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE stadium ADD data_object_polygon LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction DROP data_object_polygon, DROP pending_data_object_polygon, DROP custom_data_object_polygon');
        $this->addSql('ALTER TABLE stadium DROP data_object_polygon');
    }
}
