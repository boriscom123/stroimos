<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171205232543 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction_parameter_value ADD weight SMALLINT DEFAULT 0 NOT NULL, CHANGE value value LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE construction_parameter DROP FOREIGN KEY FK_33AC70FD7A653FE7');
        $this->addSql('DROP INDEX IDX_33AC70FD7A653FE7 ON construction_parameter');
        $this->addSql('ALTER TABLE construction_parameter DROP construction_type_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction_parameter ADD construction_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE construction_parameter ADD CONSTRAINT FK_33AC70FD7A653FE7 FOREIGN KEY (construction_type_id) REFERENCES construction_type (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_33AC70FD7A653FE7 ON construction_parameter (construction_type_id)');
        $this->addSql('ALTER TABLE construction_parameter_value DROP weight, CHANGE value value VARCHAR(1000) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
