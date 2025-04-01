<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170713231705 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE banner_audit');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE banner_audit (id INT NOT NULL, rev INT NOT NULL, template_image_id INT DEFAULT NULL, image_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, publishable TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, link VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, is_target_blank TINYINT(1) DEFAULT \'0\', created_by VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, updated_by VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, deleted_by VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, revtype VARCHAR(4) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }
}
