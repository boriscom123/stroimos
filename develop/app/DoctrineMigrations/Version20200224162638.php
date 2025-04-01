<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200224162638 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE newsletter ADD gallery_wallpaper_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C8D4662C4A FOREIGN KEY (gallery_wallpaper_id) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_7E8585C8D4662C4A ON newsletter (gallery_wallpaper_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C8D4662C4A');
        $this->addSql('DROP INDEX IDX_7E8585C8D4662C4A ON newsletter');
        $this->addSql('ALTER TABLE newsletter DROP gallery_wallpaper_id');
    }
}
