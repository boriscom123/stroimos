<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171017222600 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE video ADD author_id INT DEFAULT NULL, ADD source_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CF675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C953C1C61 FOREIGN KEY (source_id) REFERENCES article_source (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CF675F31B ON video (author_id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C953C1C61 ON video (source_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CF675F31B');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C953C1C61');
        $this->addSql('DROP INDEX IDX_7CC7DA2CF675F31B ON video');
        $this->addSql('DROP INDEX IDX_7CC7DA2C953C1C61 ON video');
        $this->addSql('ALTER TABLE video DROP author_id, DROP source_id');
    }
}
