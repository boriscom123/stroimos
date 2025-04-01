<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181025194129 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE extra_information (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE metro_station ADD extra_information_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE metro_station ADD CONSTRAINT FK_47941BBEBA0F69B9 FOREIGN KEY (extra_information_id) REFERENCES extra_information (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_47941BBEBA0F69B9 ON metro_station (extra_information_id)');
        $this->addSql('ALTER TABLE metro_line ADD extra_information_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE metro_line ADD CONSTRAINT FK_313BF34ABA0F69B9 FOREIGN KEY (extra_information_id) REFERENCES extra_information (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_313BF34ABA0F69B9 ON metro_line (extra_information_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE metro_station DROP FOREIGN KEY FK_47941BBEBA0F69B9');
        $this->addSql('ALTER TABLE metro_line DROP FOREIGN KEY FK_313BF34ABA0F69B9');
        $this->addSql('DROP TABLE extra_information');
        $this->addSql('DROP INDEX UNIQ_313BF34ABA0F69B9 ON metro_line');
        $this->addSql('ALTER TABLE metro_line DROP extra_information_id');
        $this->addSql('DROP INDEX UNIQ_47941BBEBA0F69B9 ON metro_station');
        $this->addSql('ALTER TABLE metro_station DROP extra_information_id');
    }
}
