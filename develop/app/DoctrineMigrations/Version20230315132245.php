<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20230315132245 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');


        $this->addSql('ALTER TABLE page ADD view_date_page DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE page_audit ADD view_date_page DATETIME DEFAULT NULL');
        //$this->addSql('ALTER TABLE stadium ADD data_general_contractor_org_form VARCHAR(255) DEFAULT NULL, ADD data_general_contractor_org_name VARCHAR(255) DEFAULT NULL, ADD data_customer_org_form VARCHAR(255) DEFAULT NULL, ADD data_customer_org_name VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP view_date_page');
        $this->addSql('ALTER TABLE page_audit DROP view_date_page');
        //$this->addSql('ALTER TABLE stadium DROP data_general_contractor_org_form, DROP data_general_contractor_org_name, DROP data_customer_org_form, DROP data_customer_org_name');
    }
}
