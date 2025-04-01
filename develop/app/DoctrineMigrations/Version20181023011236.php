<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181023011236 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE metrolines_galleries (metro_line_id INT NOT NULL, gallery_id INT NOT NULL, INDEX IDX_59194F4A95D6964D (metro_line_id), INDEX IDX_59194F4A4E7AF8F (gallery_id), PRIMARY KEY(metro_line_id, gallery_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE metrolines_galleries ADD CONSTRAINT FK_59194F4A95D6964D FOREIGN KEY (metro_line_id) REFERENCES metro_line (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE metrolines_galleries ADD CONSTRAINT FK_59194F4A4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE metrolines_galleries');
    }
}
