<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200825162654 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post ADD editor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D6995AC4C FOREIGN KEY (editor_id) REFERENCES author (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D6995AC4C ON post (editor_id)');
        $this->addSql('ALTER TABLE post_audit ADD editor_id INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D6995AC4C');
        $this->addSql('DROP INDEX IDX_5A8A6C8D6995AC4C ON post');
        $this->addSql('ALTER TABLE post DROP editor_id');
        $this->addSql('ALTER TABLE post_audit DROP editor_id');
    }
}
