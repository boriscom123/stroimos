<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171123184328 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organization DROP INDEX UNIQ_C1EE637CF41A619E, ADD INDEX IDX_C1EE637CF41A619E (head_id)');
        $this->addSql('ALTER TABLE contact_person DROP FOREIGN KEY FK_A44EE6F7645CF24A');
        $this->addSql('DROP INDEX UNIQ_A44EE6F7645CF24A ON contact_person');
        $this->addSql('ALTER TABLE contact_person DROP lower_organization_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact_person ADD lower_organization_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_person ADD CONSTRAINT FK_A44EE6F7645CF24A FOREIGN KEY (lower_organization_id) REFERENCES organization (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A44EE6F7645CF24A ON contact_person (lower_organization_id)');
        $this->addSql('ALTER TABLE organization DROP INDEX IDX_C1EE637CF41A619E, ADD UNIQUE INDEX UNIQ_C1EE637CF41A619E (head_id)');
    }
}
