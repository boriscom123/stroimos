<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161211202711 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction ADD organization_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE construction ADD CONSTRAINT FK_DC91E26E32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_DC91E26E32C8A3DE ON construction (organization_id)');
        $this->addSql('ALTER TABLE organization ADD title_canonical VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE INDEX title_canonical_idx ON organization (title_canonical)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction DROP FOREIGN KEY FK_DC91E26E32C8A3DE');
        $this->addSql('DROP INDEX IDX_DC91E26E32C8A3DE ON construction');
        $this->addSql('ALTER TABLE construction DROP organization_id');
        $this->addSql('DROP INDEX title_canonical_idx ON organization');
        $this->addSql('ALTER TABLE organization DROP title_canonical');
    }
}
