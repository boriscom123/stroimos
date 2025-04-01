<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180313233040 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page ADD mobile_content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE page_audit ADD mobile_content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE construction ADD mobile_content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD mobile_content LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_audit ADD mobile_content LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction DROP mobile_content');
        $this->addSql('ALTER TABLE page DROP mobile_content');
        $this->addSql('ALTER TABLE page_audit DROP mobile_content');
        $this->addSql('ALTER TABLE post DROP mobile_content');
        $this->addSql('ALTER TABLE post_audit DROP mobile_content');
    }
}
