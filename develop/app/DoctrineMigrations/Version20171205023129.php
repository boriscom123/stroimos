<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171205023129 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE construction_parameter_value (id INT AUTO_INCREMENT NOT NULL, construction_id INT NOT NULL, construction_parameter_id INT NOT NULL, value VARCHAR(1000) DEFAULT NULL, INDEX IDX_E601A3D4CF48117A (construction_id), INDEX IDX_E601A3D42B02B3B5 (construction_parameter_id), UNIQUE INDEX UNIQUE_IDX (construction_parameter_id, construction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE construction_parameter (id INT AUTO_INCREMENT NOT NULL, construction_type_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_33AC70FD2B36786B (title), INDEX IDX_33AC70FD7A653FE7 (construction_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE construction_parameter_value ADD CONSTRAINT FK_E601A3D4CF48117A FOREIGN KEY (construction_id) REFERENCES construction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE construction_parameter_value ADD CONSTRAINT FK_E601A3D42B02B3B5 FOREIGN KEY (construction_parameter_id) REFERENCES construction_parameter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE construction_parameter ADD CONSTRAINT FK_33AC70FD7A653FE7 FOREIGN KEY (construction_type_id) REFERENCES construction_type (id) ON DELETE SET NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction_parameter_value DROP FOREIGN KEY FK_E601A3D42B02B3B5');
        $this->addSql('DROP TABLE construction_parameter_value');
        $this->addSql('DROP TABLE construction_parameter');
    }
}
