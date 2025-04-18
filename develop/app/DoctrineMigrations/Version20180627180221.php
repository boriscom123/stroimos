<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180627180221 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE draft (id INT AUTO_INCREMENT NOT NULL, owner_class_name VARCHAR(255) NOT NULL, owner_entity_id INT NOT NULL, title VARCHAR(255) NOT NULL, UNIQUE INDEX unique_draft_owner (owner_class_name, owner_entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post DROP is_draft');
        $this->addSql('ALTER TABLE post_audit DROP is_draft');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE draft');
        $this->addSql('ALTER TABLE post ADD is_draft TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE post_audit ADD is_draft TINYINT(1) DEFAULT \'0\'');
    }
}
