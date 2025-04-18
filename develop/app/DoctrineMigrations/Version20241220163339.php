<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20241220163339 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE appeals (
                                id INT AUTO_INCREMENT NOT NULL,
                                name VARCHAR(255) NOT NULL,
                                surname VARCHAR(255) NOT NULL,
                                phone VARCHAR(20) NOT NULL,
                                email VARCHAR(255) NOT NULL,
                                person_type VARCHAR(50) NOT NULL,
                                organization VARCHAR(255) DEFAULT NULL,
                                api_status VARCHAR(255) DEFAULT NULL,
                                message LONGTEXT NOT NULL,
                                created_at DATETIME NOT NULL,
                                PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE appeals');
    }
}
