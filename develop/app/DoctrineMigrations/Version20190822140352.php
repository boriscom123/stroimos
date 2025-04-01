<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190822140352 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE faq_block (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, text LONGTEXT NOT NULL, title VARCHAR(255) NOT NULL, publishable TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_27CF4D273DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq_block_pages_page (faq_block_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_6CA5BD4A154F7B1B (faq_block_id), INDEX IDX_6CA5BD4AC4663E4 (page_id), PRIMARY KEY(faq_block_id, page_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq_block_tags_tag (faq_block_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_FEE87410154F7B1B (faq_block_id), INDEX IDX_FEE87410BAD26311 (tag_id), PRIMARY KEY(faq_block_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_answer (id INT AUTO_INCREMENT NOT NULL, faq_block_id INT NOT NULL, question LONGTEXT DEFAULT NULL, weight SMALLINT DEFAULT 0, answer LONGTEXT DEFAULT NULL, INDEX IDX_DD80652D154F7B1B (faq_block_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE faq_block ADD CONSTRAINT FK_27CF4D273DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE faq_block_pages_page ADD CONSTRAINT FK_6CA5BD4A154F7B1B FOREIGN KEY (faq_block_id) REFERENCES faq_block (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE faq_block_pages_page ADD CONSTRAINT FK_6CA5BD4AC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE faq_block_tags_tag ADD CONSTRAINT FK_FEE87410154F7B1B FOREIGN KEY (faq_block_id) REFERENCES faq_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE faq_block_tags_tag ADD CONSTRAINT FK_FEE87410BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_answer ADD CONSTRAINT FK_DD80652D154F7B1B FOREIGN KEY (faq_block_id) REFERENCES faq_block (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE faq_block_pages_page DROP FOREIGN KEY FK_6CA5BD4A154F7B1B');
        $this->addSql('ALTER TABLE faq_block_tags_tag DROP FOREIGN KEY FK_FEE87410154F7B1B');
        $this->addSql('ALTER TABLE question_answer DROP FOREIGN KEY FK_DD80652D154F7B1B');
        $this->addSql('DROP TABLE faq_block');
        $this->addSql('DROP TABLE faq_block_pages_page');
        $this->addSql('DROP TABLE faq_block_tags_tag');
        $this->addSql('DROP TABLE question_answer');
    }
}
