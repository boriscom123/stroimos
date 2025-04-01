<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170923160908 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE owner (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CF60E67C5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_owners_owner (document_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_455A5427C33F7837 (document_id), INDEX IDX_455A54277E3C61F9 (owner_id), PRIMARY KEY(document_id, owner_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_owners_owner (post_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_438208854B89032C (post_id), INDEX IDX_438208857E3C61F9 (owner_id), PRIMARY KEY(post_id, owner_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery_owners_owner (gallery_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_745F7FB64E7AF8F (gallery_id), INDEX IDX_745F7FB67E3C61F9 (owner_id), PRIMARY KEY(gallery_id, owner_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document_owners_owner ADD CONSTRAINT FK_455A5427C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document_owners_owner ADD CONSTRAINT FK_455A54277E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_owners_owner ADD CONSTRAINT FK_438208854B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_owners_owner ADD CONSTRAINT FK_438208857E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_owners_owner ADD CONSTRAINT FK_745F7FB64E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_owners_owner ADD CONSTRAINT FK_745F7FB67E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB6207E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_140AB6207E3C61F9 ON page (owner_id)');
        $this->addSql('ALTER TABLE page_audit ADD owner_id INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB6207E3C61F9');
        $this->addSql('ALTER TABLE document_owners_owner DROP FOREIGN KEY FK_455A54277E3C61F9');
        $this->addSql('ALTER TABLE post_owners_owner DROP FOREIGN KEY FK_438208857E3C61F9');
        $this->addSql('ALTER TABLE gallery_owners_owner DROP FOREIGN KEY FK_745F7FB67E3C61F9');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE document_owners_owner');
        $this->addSql('DROP TABLE post_owners_owner');
        $this->addSql('DROP TABLE gallery_owners_owner');
        $this->addSql('DROP INDEX IDX_140AB6207E3C61F9 ON page');
        $this->addSql('ALTER TABLE page DROP owner_id');
        $this->addSql('ALTER TABLE page_audit DROP owner_id');
    }
}
