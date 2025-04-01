<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180911120006 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE administrative_unit ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE administrative_unit ADD CONSTRAINT FK_C86D61BE3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_C86D61BE3DA5256D ON administrative_unit (image_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE administrative_unit DROP FOREIGN KEY FK_C86D61BE3DA5256D');
        $this->addSql('DROP INDEX IDX_C86D61BE3DA5256D ON administrative_unit');
        $this->addSql('ALTER TABLE administrative_unit DROP image_id');
    }
}
