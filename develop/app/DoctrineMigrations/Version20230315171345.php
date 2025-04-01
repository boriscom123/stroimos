<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20230315171345 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        //$this->addSql('DROP TABLE construction_with_null_point_backup');
        //$this->addSql('DROP TABLE title_backup');
        $this->addSql('ALTER TABLE page ADD publishable_date_page TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE page_audit ADD publishable_date_page TINYINT(1) DEFAULT NULL');
        //$this->addSql('ALTER TABLE stadium ADD data_general_contractor_org_form VARCHAR(255) DEFAULT NULL, ADD data_general_contractor_org_name VARCHAR(255) DEFAULT NULL, ADD data_customer_org_form VARCHAR(255) DEFAULT NULL, ADD data_customer_org_name VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        //$this->addSql('CREATE TABLE construction_with_null_point_backup (id INT DEFAULT 0 NOT NULL) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        //$this->addSql('CREATE TABLE title_backup (id INT NOT NULL, title VARCHAR(1000) NOT NULL COLLATE utf8_unicode_ci, table_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page DROP publishable_date_page');
        $this->addSql('ALTER TABLE page_audit DROP publishable_date_page');
        //$this->addSql('ALTER TABLE stadium DROP data_general_contractor_org_form, DROP data_general_contractor_org_name, DROP data_customer_org_form, DROP data_customer_org_name');
    }
}
