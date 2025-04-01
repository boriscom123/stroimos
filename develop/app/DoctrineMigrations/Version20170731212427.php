<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170731212427 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE highlight_newsletter (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, teaser VARCHAR(1023) DEFAULT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_DD1F3EA93DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE highlight_newsletter ADD CONSTRAINT FK_DD1F3EA93DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE newsletter ADD quote_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C8DB805178 FOREIGN KEY (quote_id) REFERENCES quote (id)');
        $this->addSql('CREATE INDEX IDX_7E8585C8DB805178 ON newsletter (quote_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE highlight_newsletter');
        $this->addSql('ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C8DB805178');
        $this->addSql('DROP INDEX IDX_7E8585C8DB805178 ON newsletter');
        $this->addSql('ALTER TABLE newsletter DROP quote_id');
    }
}
