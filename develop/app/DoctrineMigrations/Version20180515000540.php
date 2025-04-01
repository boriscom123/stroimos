<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180515000540 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post ADD journalist_writer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA77B1A7A FOREIGN KEY (journalist_writer_id) REFERENCES author (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA77B1A7A ON post (journalist_writer_id)');
        $this->addSql('ALTER TABLE post_audit ADD journalist_writer_id INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA77B1A7A');
        $this->addSql('DROP INDEX IDX_5A8A6C8DA77B1A7A ON post');
        $this->addSql('ALTER TABLE post DROP journalist_writer_id');
        $this->addSql('ALTER TABLE post_audit DROP journalist_writer_id');
    }
}
