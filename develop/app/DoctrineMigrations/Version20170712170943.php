<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170712170943 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE banner (id INT AUTO_INCREMENT NOT NULL, template_image_id INT NOT NULL, image_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, publishable TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, link VARCHAR(255) DEFAULT NULL, is_target_blank TINYINT(1) DEFAULT \'0\' NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_6F9DB8E762F3151E (template_image_id), INDEX IDX_6F9DB8E73DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner_pages_page (banner_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_9DB5664F684EC833 (banner_id), INDEX IDX_9DB5664FC4663E4 (page_id), PRIMARY KEY(banner_id, page_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner_audit (id INT NOT NULL, rev INT NOT NULL, template_image_id INT DEFAULT NULL, image_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, publishable TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, is_target_blank TINYINT(1) DEFAULT \'0\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE banner ADD CONSTRAINT FK_6F9DB8E762F3151E FOREIGN KEY (template_image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE banner ADD CONSTRAINT FK_6F9DB8E73DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE banner_pages_page ADD CONSTRAINT FK_9DB5664F684EC833 FOREIGN KEY (banner_id) REFERENCES banner (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE banner_pages_page ADD CONSTRAINT FK_9DB5664FC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE banner_pages_page DROP FOREIGN KEY FK_9DB5664F684EC833');
        $this->addSql('DROP TABLE banner');
        $this->addSql('DROP TABLE banner_pages_page');
        $this->addSql('DROP TABLE banner_audit');
    }
}
