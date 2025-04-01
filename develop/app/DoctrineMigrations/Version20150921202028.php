<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150921202028 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fos_comment ADD file_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_comment ADD CONSTRAINT FK_BF3A210293CB796C FOREIGN KEY (file_id) REFERENCES media__media (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BF3A210293CB796C ON fos_comment (file_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fos_comment DROP FOREIGN KEY FK_BF3A210293CB796C');
        $this->addSql('DROP INDEX UNIQ_BF3A210293CB796C ON fos_comment');
        $this->addSql('ALTER TABLE fos_comment DROP file_id');
    }
}
