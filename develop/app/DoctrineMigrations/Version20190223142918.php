<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;


class Version20190223142918 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('UPDATE construction SET custom_data_object_district = REPLACE(custom_data_object_district, \'район:\', \'\')');
        $this->addSql('UPDATE construction SET custom_data_object_district = REPLACE(custom_data_object_district, \'Район:\', \'\')');
        $this->addSql('UPDATE construction SET custom_data_object_district = REPLACE(custom_data_object_district, \'район\', \'\')');
        $this->addSql('UPDATE construction SET custom_data_object_district = TRIM(CHAR(9) FROM TRIM(custom_data_object_district))');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
