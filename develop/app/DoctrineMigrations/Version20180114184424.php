<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180114184424 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE error_report ADD referrer VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQUE_IDX ON newsletter_infographics');
        $this->addSql('DROP INDEX UNIQUE_IDX ON newsletter_galleries');
        $this->addSql('DROP INDEX UNIQUE_IDX ON newsletter_videos');
        $this->addSql('DROP INDEX UNIQUE_IDX ON newsletter_posts');
        $this->addSql('DROP INDEX UNIQUE_IDX ON construction_parameter_value');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQUE_IDX ON construction_parameter_value (construction_parameter_id, construction_id)');
        $this->addSql('ALTER TABLE error_report DROP referrer');
        $this->addSql('CREATE UNIQUE INDEX UNIQUE_IDX ON newsletter_galleries (newsletter_id, gallery_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQUE_IDX ON newsletter_infographics (newsletter_id, infographics_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQUE_IDX ON newsletter_posts (newsletter_id, post_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQUE_IDX ON newsletter_videos (newsletter_id, video_id)');
    }
}
