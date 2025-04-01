<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180601193227 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE administrative_unit ADD square INT DEFAULT NULL, ADD population INT DEFAULT NULL, ADD polygon MULTIPOLYGON DEFAULT NULL COMMENT \'(DC2Type:multipolygon)\', ADD area_of_the_territory INT DEFAULT NULL, ADD content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE construction ADD point POINT DEFAULT NULL COMMENT \'(DC2Type:point)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE administrative_unit DROP square, DROP population, DROP polygon, DROP area_of_the_territory, DROP content');
        $this->addSql('ALTER TABLE construction DROP point');
    }
}
