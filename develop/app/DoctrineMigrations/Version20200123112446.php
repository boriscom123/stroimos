<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200123112446 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE text_block_usage_places_usage_place (text_block_id INT NOT NULL, usage_place_id INT NOT NULL, INDEX IDX_C3271E295FAF0E1E (text_block_id), INDEX IDX_C3271E2980F02B9A (usage_place_id), PRIMARY KEY(text_block_id, usage_place_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usage_place (id INT AUTO_INCREMENT NOT NULL, class VARCHAR(255) NOT NULL, entity_id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE text_block_usage_places_usage_place ADD CONSTRAINT FK_C3271E295FAF0E1E FOREIGN KEY (text_block_id) REFERENCES text_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE text_block_usage_places_usage_place ADD CONSTRAINT FK_C3271E2980F02B9A FOREIGN KEY (usage_place_id) REFERENCES usage_place (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE text_block_usage_places_usage_place DROP FOREIGN KEY FK_C3271E2980F02B9A');
        $this->addSql('DROP TABLE text_block_usage_places_usage_place');
        $this->addSql('DROP TABLE usage_place');
    }
}
