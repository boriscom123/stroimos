<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170731210808 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE newsletter_galleries DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE newsletter_galleries ADD id INT AUTO_INCREMENT NOT NULL PRIMARY KEY, ADD priority_position SMALLINT DEFAULT 0 NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQUE_IDX ON newsletter_galleries (newsletter_id, gallery_id)');
        $this->addSql('ALTER TABLE newsletter_videos DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE newsletter_videos ADD id INT AUTO_INCREMENT NOT NULL PRIMARY KEY, ADD priority_position SMALLINT DEFAULT 0 NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQUE_IDX ON newsletter_videos (newsletter_id, video_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQUE_IDX ON newsletter_galleries');
        $this->addSql('ALTER TABLE newsletter_galleries DROP id, DROP priority_position');
        $this->addSql('ALTER TABLE newsletter_galleries ADD PRIMARY KEY (newsletter_id, gallery_id)');
        $this->addSql('DROP INDEX UNIQUE_IDX ON newsletter_videos');
        $this->addSql('ALTER TABLE newsletter_videos DROP id, DROP priority_position');
        $this->addSql('ALTER TABLE newsletter_videos ADD PRIMARY KEY (newsletter_id, video_id)');
    }
}
