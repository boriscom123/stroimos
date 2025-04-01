<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170728182234 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE newsletter_posts DROP PRIMARY KEY, ADD id INT AUTO_INCREMENT NOT NULL PRIMARY KEY');
        $this->addSql('ALTER TABLE newsletter_posts ADD priority_position SMALLINT NOT NULL DEFAULT \'0\'');
        $this->addSql('ALTER TABLE newsletter_posts ADD UNIQUE UNIQUE_IDX(newsletter_id, post_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE newsletter_posts DROP COLUMN id, DROP COLUMN priority_position');
        $this->addSql('ALTER TABLE newsletter_posts DROP INDEX UNIQUE_IDX');
        $this->addSql('ALTER TABLE newsletter_posts ADD PRIMARY KEY(newsletter_id, post_id)');
    }
}
