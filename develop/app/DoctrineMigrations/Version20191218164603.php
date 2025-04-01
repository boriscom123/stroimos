<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191218164603 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE road_parameter_value (id INT AUTO_INCREMENT NOT NULL, road_id INT NOT NULL, construction_parameter_id INT NOT NULL, value LONGTEXT DEFAULT NULL, weight SMALLINT DEFAULT 0, INDEX IDX_D66CBABA962F8178 (road_id), INDEX IDX_D66CBABA2B02B3B5 (construction_parameter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE road_parameter_value ADD CONSTRAINT FK_D66CBABA962F8178 FOREIGN KEY (road_id) REFERENCES road (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE road_parameter_value ADD CONSTRAINT FK_D66CBABA2B02B3B5 FOREIGN KEY (construction_parameter_id) REFERENCES construction_parameter (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE road_parameter_value');
    }
}
