<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200919155515 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE spotlight_item ADD carousel_image1_id INT DEFAULT NULL, ADD carousel_image2_id INT DEFAULT NULL, ADD carousel_image3_id INT DEFAULT NULL, ADD carousel_image4_id INT DEFAULT NULL, ADD carousel_image5_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43B18ECD88B FOREIGN KEY (carousel_image1_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43BA597765 FOREIGN KEY (carousel_image2_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43BB2E51000 FOREIGN KEY (carousel_image3_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43B2F3228B9 FOREIGN KEY (carousel_image4_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43B978E4FDC FOREIGN KEY (carousel_image5_id) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_A4BFD43B18ECD88B ON spotlight_item (carousel_image1_id)');
        $this->addSql('CREATE INDEX IDX_A4BFD43BA597765 ON spotlight_item (carousel_image2_id)');
        $this->addSql('CREATE INDEX IDX_A4BFD43BB2E51000 ON spotlight_item (carousel_image3_id)');
        $this->addSql('CREATE INDEX IDX_A4BFD43B2F3228B9 ON spotlight_item (carousel_image4_id)');
        $this->addSql('CREATE INDEX IDX_A4BFD43B978E4FDC ON spotlight_item (carousel_image5_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE spotlight_item DROP FOREIGN KEY FK_A4BFD43B18ECD88B');
        $this->addSql('ALTER TABLE spotlight_item DROP FOREIGN KEY FK_A4BFD43BA597765');
        $this->addSql('ALTER TABLE spotlight_item DROP FOREIGN KEY FK_A4BFD43BB2E51000');
        $this->addSql('ALTER TABLE spotlight_item DROP FOREIGN KEY FK_A4BFD43B2F3228B9');
        $this->addSql('ALTER TABLE spotlight_item DROP FOREIGN KEY FK_A4BFD43B978E4FDC');
        $this->addSql('DROP INDEX IDX_A4BFD43B18ECD88B ON spotlight_item');
        $this->addSql('DROP INDEX IDX_A4BFD43BA597765 ON spotlight_item');
        $this->addSql('DROP INDEX IDX_A4BFD43BB2E51000 ON spotlight_item');
        $this->addSql('DROP INDEX IDX_A4BFD43B2F3228B9 ON spotlight_item');
        $this->addSql('DROP INDEX IDX_A4BFD43B978E4FDC ON spotlight_item');
        $this->addSql('ALTER TABLE spotlight_item DROP carousel_image1_id, DROP carousel_image2_id, DROP carousel_image3_id, DROP carousel_image4_id, DROP carousel_image5_id');
    }
}
