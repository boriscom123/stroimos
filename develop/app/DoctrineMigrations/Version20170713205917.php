<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170713205917 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE quote (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, text TEXT NOT NULL, title VARCHAR(255) NOT NULL, publishable TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, deleted_by VARCHAR(255) DEFAULT NULL, INDEX IDX_6B71CBF4217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quote_pages_page (quote_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_EF97861BDB805178 (quote_id), INDEX IDX_EF97861BC4663E4 (page_id), PRIMARY KEY(quote_id, page_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE quote_pages_page ADD CONSTRAINT FK_EF97861BDB805178 FOREIGN KEY (quote_id) REFERENCES quote (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE quote_pages_page ADD CONSTRAINT FK_EF97861BC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quote_pages_page DROP FOREIGN KEY FK_EF97861BDB805178');
        $this->addSql('DROP TABLE quote');
        $this->addSql('DROP TABLE quote_pages_page');
    }
}
