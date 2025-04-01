<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200304165839 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE newsletter ADD spotlight_item_wallpaper_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C8C11738F2 FOREIGN KEY (spotlight_item_wallpaper_id) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_7E8585C8C11738F2 ON newsletter (spotlight_item_wallpaper_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C8C11738F2');
        $this->addSql('DROP INDEX IDX_7E8585C8C11738F2 ON newsletter');
        $this->addSql('ALTER TABLE newsletter DROP spotlight_item_wallpaper_id');
    }
}
